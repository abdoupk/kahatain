<script lang="ts" setup>
import type { IndexParams } from '@/types/types'

import { traineesOrphansFilters } from '@/constants/filters'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import AcademicPhases from '@/Pages/Tenant/trainees/index/AcademicPhases.vue'
import DataTable from '@/Pages/Tenant/trainees/index/DataTable.vue'
import TraineesChart from '@/Pages/Tenant/trainees/index/TraineesChart.vue'

import TheNoResultsTable from '@/Components/Global/DataTable/TheNoResultsTable.vue'
import TheTableFooter from '@/Components/Global/DataTable/TheTableFooter.vue'
import TheTableHeader from '@/Components/Global/DataTable/TheTableHeader.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort } from '@/utils/helper'

const props = defineProps<{
    academicLevels: unknown
    totalTrainees: unknown
    traineesPerPhase: unknown
    traineesPerInstitution: unknown
    orphans: unknown
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

defineOptions({
    layout: TheLayout
})
</script>

<template>
    <Head :title="$t('orphan_trainees')"></Head>

    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Academic Phases -->
        <academic-phases :academicLevels :totalTrainees></academic-phases>
        <!-- END: Academic Phases -->

        <!-- BEGIN: Trainees Chart -->
        <trainees-chart :totalTrainees :traineesPerInstitution :traineesPerPhase></trainees-chart>
        <!-- END: Trainees Chart -->

        <suspense>
            <div class="col-span-12">
                <the-table-header
                    :filters="traineesOrphansFilters"
                    :pagination-data="orphans"
                    :params
                    :url="route('tenant.trainees.index')"
                    entries="orphans"
                    export-pdf-url=""
                    export-xlsx-url=""
                    filterable
                    searchable
                    title=""
                    @change-filters="params.filters = $event"
                >
                </the-table-header>

                <template v-if="orphans.data.length > 0">
                    <data-table :orphans :params @sort="sort"></data-table>

                    <the-table-footer
                        :pagination-data="orphans"
                        :params
                        :url="route('tenant.trainees.index')"
                        preserve-scroll
                        preserve-state
                    ></the-table-footer>
                </template>

                <the-no-results-table v-else></the-no-results-table>
            </div>

            <template #fallback>
                <the-content-loader></the-content-loader>
            </template>
        </suspense>
    </div>
</template>
