<script lang="ts" setup>
import type { ArchiveIndexResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { formatDate } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    items: PaginationData<ArchiveIndexResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
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
                        <Link :href="item.url" class="font-medium rtl:!font-semibold">
                            {{ item.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <Link
                            v-if="item.savedBy.id"
                            :href="route('tenant.members.index') + `?show=${item.savedBy.id}`"
                            class="font-medium rtl:!font-semibold"
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
</template>
