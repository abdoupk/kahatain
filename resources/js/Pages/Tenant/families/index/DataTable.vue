<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<FamiliesIndexResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort', 'showDeleteModal'])
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
                            {{ $t('the_sponsor') }}
                        </the-table-th>

                        <the-table-th class="text-start">{{ $t('validation.attributes.address') }}</the-table-th>

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
                                v-if="hasPermission('view_sponsors')"
                                :href="route('tenant.sponsors.show', family.sponsor.id)"
                                class="font-medium"
                            >
                                {{ family.name }}
                            </Link>

                            <span v-else> {{ family.name }}</span>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            {{ family.address }}
                            <Link
                                :href="route('tenant.zones.index') + '?show=' + family.zone.id"
                                class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                            >
                                {{ family.zone?.name }}
                            </Link>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ family.file_number }}
                        </the-table-td>

                        <the-table-td class="w-40 text-start">
                            <div class="whitespace-nowrap">
                                {{ formatDate(family.start_date, 'long') }}
                            </div>
                        </the-table-td>

                        <the-table-td-actions v-if="hasPermission(['update_families', 'delete_families'])">
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

        <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
            <div v-for="family in families.data" :key="family.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            {{ family.name }}
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            {{ family.file_number }}
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="w-3/4">
                            <p class="truncate">{{ family.address }}</p>
                            <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                                {{ family.zone?.name }}
                            </div>
                            <div
                                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                            >
                                {{ family.start_date }}
                            </div>
                        </div>
                        <div class="flex w-1/4 items-center justify-end">
                            <Link
                                v-if="hasPermission('update_families')"
                                :href="route('tenant.families.show', family.id)"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                >{{ $t('edit') }}
                            </Link>
                            <a
                                v-if="hasPermission('delete_families')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', family.id)"
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
