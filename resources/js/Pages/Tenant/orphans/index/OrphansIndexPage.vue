<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import { orphansFilters } from '@/constants/filters'
import { orphansSorts } from '@/constants/sorts'
import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/index/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    orphans: PaginationData<OrphansIndexResource>
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
    <Head :title="$t('the_orphans')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_orphans')"
                :filters="orphansFilters"
                :pagination-data="orphans"
                :params="params"
                :sortableFields="orphansSorts"
                :title="$t('list', { attribute: $t('the_orphans') })"
                :url="route('tenant.orphans.index')"
                entries="orphans"
                export-pdf-url="tenant.orphans.export.pdf"
                export-xlsx-url="tenant.orphans.export.xlsx"
                filterable
                searchable
                sortable
                @change-filters="params.filters = $event"
            ></the-table-header>

            <template v-if="orphans.data.length > 0">
                <data-table :orphans :params @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="orphans"
                    :params
                    :url="route('tenant.orphans.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
