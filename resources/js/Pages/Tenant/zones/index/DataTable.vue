<script lang="ts" setup>
import type { IndexParams, PaginationData, ZonesIndexResource } from '@/types/types'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    zones: PaginationData<ZonesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="@container">
        <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th
                            :direction="params.directions?.name"
                            class="text-start"
                            sortable
                            @click="emit('sort', 'name')"
                        >
                            {{ $t('the_zone') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('neighborhoods') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.families_count"
                            class="text-center"
                            sortable
                            @click.prevent="emit('sort', 'families_count')"
                        >
                            {{ $t('families_count') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.created_at"
                            class="text-center"
                            sortable
                            @click.prevent="emit('sort', 'created_at')"
                        >
                            {{ $t('added_at') }}
                        </the-table-th>

                        <the-table-th v-if="hasPermission(['update_zones', 'delete_zones'])" class="text-center">
                            {{ $t('actions') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(zone, index) in zones.data" :key="zone.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (zones.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="!min-w-40 !max-w-40 truncate">
                            <a class="font-medium" href="#" @click.prevent="emit('showDetailsModal', zone.id)">
                                {{ zone.name }}
                            </a>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-start">
                            {{ zone.description }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ zone.families_count }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ zone.created_at }}
                        </the-table-td>

                        <the-table-td-actions v-if="hasPermission(['update_zones', 'delete_zones'])">
                            <div class="flex items-center justify-center">
                                <a
                                    v-if="hasPermission('update_zones')"
                                    class="me-3 flex items-center"
                                    href="javascript:void(0)"
                                    @click="emit('showEditModal', zone.id)"
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                    {{ $t('edit') }}
                                </a>
                                <a
                                    v-if="hasPermission('delete_zones')"
                                    class="flex items-center text-danger"
                                    href="javascript:void(0)"
                                    @click="emit('showDeleteModal', zone.id)"
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-trash-can" />
                                    {{ $t('delete') }}
                                </a>
                            </div>
                        </the-table-td-actions>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
            <div v-for="zone in zones.data" :key="zone.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            {{ zone.name }}
                        </div>

                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            <base-tippy :content="$t('families_count')">
                                {{ zone.families_count }}
                            </base-tippy>
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="w-3/4">
                            <p class="truncate">
                                {{ zone.description }}
                            </p>

                            <div
                                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                            >
                                {{ zone.created_at }}
                            </div>
                        </div>
                        <div class="flex w-1/4 items-center justify-end">
                            <a
                                v-if="hasPermission('view_zones')"
                                class="me-2 flex items-center"
                                href="javascript:void(0)"
                                @click="emit('showDetailsModal', zone.id)"
                            >
                                {{ $t('show') }}
                            </a>
                            <a
                                v-if="hasPermission('update_zones')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click="emit('showEditModal', zone.id)"
                                >{{ $t('edit') }}
                            </a>
                            <a
                                v-if="hasPermission('delete_zones')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', zone.id)"
                            >
                                {{ $t('delete') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
