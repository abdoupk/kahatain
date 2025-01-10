<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

import { sponsorsFilters } from '@/constants/filters'
import { sponsorsSorts } from '@/constants/sorts'
import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort, hasPermission } from '@/utils/helper'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/sponsors/index/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
    params: IndexParams
}>()

const params = ref<IndexParams>({
    perPage: props.params.perPage,
    page: props.params.page,
    directions: props.params.directions,
    fields: props.params.fields,
    filters: props.params.filters,
    search: props.params.search
})

const sort = (field: string) => handleSort(field, params.value)
</script>

<template>
    <Head :title="$t('the_sponsors')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_orphans')"
                :filters="sponsorsFilters"
                :pagination-data="sponsors"
                :params="params"
                :sortableFields="sponsorsSorts"
                :title="$t('list', { attribute: $t('the_sponsors') })"
                :url="route('tenant.sponsors.index')"
                entries="sponsors"
                export-pdf-url="tenant.sponsors.export.pdf"
                export-xlsx-url="tenant.sponsors.export.xlsx"
                filterable
                searchable
                sortable
                @change-filters="params.filters = $event"
            ></the-table-header>

            <template v-if="sponsors.data.length > 0">
                <data-table :params :sponsors @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="sponsors"
                    :params
                    :url="route('tenant.sponsors.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
