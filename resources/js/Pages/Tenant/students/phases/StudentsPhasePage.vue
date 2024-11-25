<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TrimesterFilter from '@/Pages/Tenant/students/phases/TrimesterFilter.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/students/phases/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    students: PaginationData<OrphansIndexResource>
    subjects: Array
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

// Get the segments of the pathname
const segments = new URL(window.location.href).pathname.split('/').filter((part) => part !== '')

const url = route('tenant.students.phase.index', {
    phase: segments[segments.length - 2],
    academicLevel: segments[segments.length - 1]
})

const handleSelectTrimester = (trimester: string) => {
    params.value.filters = [
        {
            field: 'trimester',
            value: trimester,
            operator: '='
        }
    ]

    getDataForIndexPages(url, params.value, {
        preserveScroll: true,
        preserveState: true
    })
}
</script>

<template>
    <Head :title="$t('the_orphans')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_orphans')"
                :pagination-data="students"
                :params
                :dont-show-filters="true"
                :title="$t('list', { attribute: $t('the_orphans') })"
                :url
                entries="students"
                export-pdf-url="tenant.orphans.export.pdf"
                export-xlsx-url="tenant.orphans.export.xlsx"
                searchable
                @change-filters="params.filters = $event"
            >
                <template #ExtraFilters>
                    <trimester-filter @filter="handleSelectTrimester"></trimester-filter>
                </template>
            </the-table-header>

            <template v-if="students.data.length > 0">
                <data-table :params :students @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="students"
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
