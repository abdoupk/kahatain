<script lang="ts" setup>
import type { RecentFamiliesType } from '@/types/dashboard'

import { Link } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BaseTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTable.vue'))

const BaseTbodyTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTbodyTable.vue'))

const BaseTheadTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTheadTable.vue'))

const BaseTrTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTrTable.vue'))

const TheTableTd = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableTd.vue'))

const TheTableTdActions = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableTdActions.vue'))

const TheTableTh = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableTh.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

defineProps<{
    recentFamilies: RecentFamiliesType
}>()

const emit = defineEmits(['deleteFamily'])
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start">
                        {{ $t('the_family') }}
                    </the-table-th>

                    <the-table-th class="text-start">{{ $t('validation.attributes.address') }}</the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('orphans_count') }}
                    </the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('validation.attributes.branch_id') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="family in recentFamilies" :key="family.id" class="intro-x">
                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link :href="route('tenant.families.show', family.id)" class="font-medium rtl:!font-semibold">
                            {{ family.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        {{ family.address }}
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

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link :href="route('tenant.families.show', family.id)" class="font-medium rtl:!font-semibold">
                            {{ family.branch.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td-actions>
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
                                @click="emit('deleteFamily', family.id)"
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
