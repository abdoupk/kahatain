<script lang="ts" setup>
import type { ArchiveOccasionType, IndexParams, PaginationData, ZakatFamiliesResource } from '@/types/types'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { formatCurrency, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/archive/details/zakat/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    families: PaginationData<ZakatFamiliesResource>
    params: IndexParams
    archive: ArchiveOccasionType
    amount: number
}>()

const params = ref<IndexParams>({
    perPage: props.params.perPage,
    page: props.params.page,
    directions: props.params.directions,
    fields: props.params.fields,
    filters: props.params.filters,
    search: props.params.search,
    archive: props.archive.id
})

const total = formatCurrency(props.amount)
</script>

<template>
    <Head
        :title="
            $t('exports.archive.zakat_families', {
                date: String(archive.date),
                attribute: String(total)
            })
        "
    ></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_occasions')"
                :filters="[]"
                :pagination-data="families"
                :params="params"
                :title="$t('exports.archive.zakat_families', { date: String(archive.date), attribute: String(total) })"
                :url="$page.url"
                entries="families"
                export-pdf-url="tenant.archive.export.zakat.pdf"
                export-xlsx-url="tenant.archive.export.zakat.xlsx"
            >
            </the-table-header>

            <template v-if="families.data.length > 0">
                <data-table :families :params></data-table>

                <the-table-footer :pagination-data="families" :params :url="$page.url"></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
