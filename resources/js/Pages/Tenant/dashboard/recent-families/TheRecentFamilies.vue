<script lang="ts" setup>
import type { RecentFamiliesType } from '@/types/dashboard'

import { Link, router } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BaseTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTable.vue'))

const BaseTbodyTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTbodyTable.vue'))

const BaseTheadTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTheadTable.vue'))

const BaseTrTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTrTable.vue'))

const TheTableTd = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableTd.vue'))

const TheTableTdActions = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableTdActions.vue'))

const TheTableTh = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableTh.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/Global/SvgLoader.vue'))

defineProps<{
    recentFamilies: RecentFamiliesType
}>()

const deleteFamily = (id: string) => {
    router.delete(route('tenant.families.destroy', id), {
        preserveScroll: true,
        only: ['recentFamilies']
    })
}
</script>

<template>
    <suspense suspensible>
        <div class="col-span-12 mt-6">
            <div class="intro-y block h-10 items-center sm:flex">
                <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">{{ $t('Recent Added Families') }}</h2>
            </div>
            <div class="@container">
                <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
                    <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                        <base-thead-table>
                            <base-tr-table>
                                <the-table-th class="text-start">
                                    {{ $t('the_family') }}
                                </the-table-th>

                                <the-table-th class="text-start"
                                    >{{ $t('validation.attributes.address') }}
                                </the-table-th>

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
                                    <Link :href="route('tenant.families.show', family.id)" class="font-medium">
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

                                <the-table-td class="text-center">{{ family.orphans_count }}</the-table-td>

                                <the-table-td class="!min-w-40 !max-w-40 truncate">
                                    <Link :href="route('tenant.families.show', family.id)" class="font-medium">
                                        {{ family.branch.name }}
                                    </Link>
                                </the-table-td>

                                <the-table-td-actions>
                                    <div class="flex items-center justify-center">
                                        <Link
                                            v-if="hasPermission('edit_families')"
                                            :href="route('tenant.families.edit', family.id)"
                                            class="me-3 flex items-center"
                                        >
                                            <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                            {{ $t('edit') }}
                                        </Link>

                                        <a
                                            v-if="hasPermission('delete_families')"
                                            class="flex items-center text-danger"
                                            @click.prevent="deleteFamily(family.id)"
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
                    <div
                        v-for="family in recentFamilies"
                        :key="family.id"
                        class="intro-y !z-10 col-span-12 @xl:col-span-6"
                    >
                        <div class="box p-5">
                            <div class="flex">
                                <div class="me-3 truncate text-lg font-medium">
                                    {{ family.name }}
                                </div>
                                <div
                                    class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                                >
                                    <base-tippy :content="$t('orphans_count')">
                                        {{ family.orphans_count }}
                                    </base-tippy>
                                </div>
                            </div>
                            <div class="mt-6 flex">
                                <div class="w-3/4">
                                    <p class="truncate">{{ family.address }}</p>
                                    <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                                        {{ family.zone?.name }}
                                    </div>
                                </div>
                                <div class="flex w-1/4 items-center justify-end">
                                    <Link
                                        :href="route('tenant.families.show', family.id)"
                                        class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                        >{{ $t('edit') }}
                                    </Link>
                                    <a
                                        v-if="hasPermission('delete_families')"
                                        class="font-semibold text-danger"
                                        @click.prevent="deleteFamily(family.id)"
                                    >
                                        {{ $t('delete') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </suspense>

    <!--        <div class="intro-y mt-8 overflow-auto sm:mt-0 lg:overflow-visible">-->
    <!--            -->
    <!--        </div>-->
</template>
