<script lang="ts" setup>
import type { ArchiveIndexResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { formatDate } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ items: PaginationData<ArchiveIndexResource>; params: IndexParams }>()
</script>

<template>
    <div class="@container">
        <div class="intro-y col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible !z-30">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th class="text-start">
                            {{ $t('the_item') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('archive.saved_by') }}
                        </the-table-th>

                        <the-table-th class="text-center">{{ $t('validation.attributes.created_at') }}</the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('archive.families_count') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(item, index) in items.data" :key="item.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (items.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="!min-w-44 !max-w-44 truncate">
                            <Link :href="item.url" class="font-medium">
                                {{ item.name }}
                            </Link>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            <Link
                                v-if="item.savedBy.id"
                                :href="route('tenant.members.index') + `?show=${item.savedBy.id}`"
                                class="font-medium"
                            >
                                {{ item.savedBy.name }}
                            </Link>

                            <span v-else> — </span>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ formatDate(item.created_at, 'long') }}
                        </the-table-td>

                        <the-table-td class="w-40 text-center">
                            {{ item.families_count }}
                        </the-table-td>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
            <div v-for="item in items.data" :key="item.id" class="intro-y col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            <Link :href="item.url">{{ item.name }}</Link>
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            <base-tippy :content="$t('archive.families_count')">
                                {{ item.families_count }}
                            </base-tippy>
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="w-3/4">
                            <Link
                                :href="route('tenant.members.index') + `?show=${item.savedBy.id}`"
                                class="truncate font-medium"
                            >
                                {{ item.savedBy.name }}
                            </Link>

                            <div
                                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                            >
                                {{ item.readable_created_at }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
