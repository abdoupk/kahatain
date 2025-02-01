<script lang="ts" setup>
import type { IndexParams } from '@/types/types'

import { collegeStudentsFilters } from '@/constants/filters'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import AcademicPhases from '@/Pages/Tenant/college-students/index/AcademicPhases.vue'
import DataTable from '@/Pages/Tenant/college-students/index/DataTable.vue'
import StudentsChart from '@/Pages/Tenant/college-students/index/StudentsChart.vue'

import TheNoResultsTable from '@/Components/Global/DataTable/TheNoResultsTable.vue'
import TheTableFooter from '@/Components/Global/DataTable/TheTableFooter.vue'
import TheTableHeader from '@/Components/Global/DataTable/TheTableHeader.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort } from '@/utils/helper'

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    orphans: unknown
    params: IndexParams
    academicLevels: unknown
    totalCollegeStudents: unknown
    collegeStudentsPerPhase: unknown
    studentsPerUniversity: unknown
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
    <Head :title="$t('the_college_students')"></Head>

    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Academic Phases -->
        <academic-phases :academicLevels :totalCollegeStudents></academic-phases>
        <!-- END: Academic Phases -->

        <!-- BEGIN: Students Chart -->
        <students-chart :collegeStudentsPerPhase :studentsPerUniversity :totalCollegeStudents></students-chart>
        <!-- END: Students Chart -->

        <suspense>
            <div class="col-span-12">
                <the-table-header
                    :filters="collegeStudentsFilters"
                    :pagination-data="orphans"
                    :params
                    :url="route('tenant.college-students.index')"
                    entries="college_students"
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
                        :url="route('tenant.college-students.index')"
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
