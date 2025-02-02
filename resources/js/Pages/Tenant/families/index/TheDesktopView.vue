<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<FamiliesIndexResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
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
                        {{ $t('the_sponsor') }}
                    </the-table-th>

                    <the-table-th class="text-start">{{ $t('validation.attributes.address') }}</the-table-th>

                    <the-table-th
                        :direction="params.directions?.orphans_count"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'orphans_count')"
                    >
                        {{ $t('orphans_count') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.file_number"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'file_number')"
                    >
                        {{ $t('file_number') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.start_date"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'start_date')"
                    >
                        {{ $t('validation.attributes.starting_sponsorship_date') }}
                    </the-table-th>

                    <the-table-th v-if="hasPermission(['update_families', 'delete_families'])" class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(family, index) in families.data" :key="family.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (families.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link
                            v-if="hasPermission('view_sponsors') && family.sponsor?.id"
                            :href="route('tenant.sponsors.show', family.sponsor.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ family.name }}
                        </Link>

                        <span v-else> {{ family.name }}</span>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <base-tippy :content="family.address">
                            {{ family.address }}
                        </base-tippy>

                        <Link
                            :href="route('tenant.zones.index') + '?show=' + family.zone?.id"
                            class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                        >
                            {{ family.zone?.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ family.orphans_count }}
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ family.file_number }}
                    </the-table-td>

                    <the-table-td class="w-40 text-start">
                        <div class="whitespace-nowrap">
                            {{ formatDate(family.start_date, 'long') }}
                        </div>
                    </the-table-td>

                    <the-table-td-actions v-if="hasPermission(['update_families', 'delete_families', 'view_families'])">
                        <div class="flex items-center justify-center">
                            <Link
                                v-if="hasPermission('view_families')"
                                :href="route('tenant.families.show', family.id)"
                                class="me-3 flex items-center"
                            >
                                <svg-loader class="me-1 h-5 w-5 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </Link>

                            <Link
                                v-if="hasPermission('update_families')"
                                :href="route('tenant.families.edit', family.id)"
                                class="me-3 flex items-center"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                {{ $t('edit') }}
                            </Link>

                            <a
                                v-if="hasPermission('delete_families')"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', family.id)"
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
</template>
