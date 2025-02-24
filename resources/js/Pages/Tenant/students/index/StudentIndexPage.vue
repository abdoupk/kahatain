<script lang="ts" setup>
import { AcademicLevelsIndexResource } from '@/types/lessons'
import { StudentsPerInstitution, StudentsPerPhase } from '@/types/orphans'
import type { IndexParams } from '@/types/types'

import { studentsFilters } from '@/constants/filters'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import AcademicPhases from '@/Pages/Tenant/students/index/AcademicPhases.vue'
import DataTable from '@/Pages/Tenant/students/index/DataTable.vue'
import StudentsChart from '@/Pages/Tenant/students/index/StudentsChart.vue'

import TheNoResultsTable from '@/Components/Global/DataTable/TheNoResultsTable.vue'
import TheTableFooter from '@/Components/Global/DataTable/TheTableFooter.vue'
import TheTableHeader from '@/Components/Global/DataTable/TheTableHeader.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort } from '@/utils/helper'

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    academicLevels: AcademicLevelsIndexResource
    totalStudents: number
    studentsPerPhase: StudentsPerPhase
    studentsPerSchool: StudentsPerInstitution
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
</script>

<template>
    <Head :title="$t('list', { attribute: $t('the_students') })"></Head>

    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Academic Phases -->
        <academic-phases :academicLevels :totalStudents></academic-phases>
        <!-- END: Academic Phases -->

        <!-- BEGIN: Students Chart -->
        <students-chart :studentsPerPhase :studentsPerSchool :totalStudents></students-chart>
        <!-- END: Students Chart -->

        <suspense>
            <div class="col-span-12">
                <the-table-header
                    :filters="studentsFilters"
                    :pagination-data="orphans"
                    :params
                    :url="route('tenant.students.index')"
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
                    <data-table :orphans :params class="mb-2" @sort="sort"></data-table>

                    <the-table-footer
                        :pagination-data="orphans"
                        :params
                        :url="route('tenant.students.index')"
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
