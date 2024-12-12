<script lang="ts" setup>
import type { IndexParams } from '@/types/types'

import { ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import AcademicPhases from '@/Pages/Tenant/college-students/index/AcademicPhases.vue'
import DataTable from '@/Pages/Tenant/college-students/index/DataTable.vue'
import StudentsChart from '@/Pages/Tenant/college-students/index/StudentsChart.vue'

import TheNoResultsTable from '@/Components/Global/DataTable/TheNoResultsTable.vue'
import TheTableFooter from '@/Components/Global/DataTable/TheTableFooter.vue'
import TheTableHeader from '@/Components/Global/DataTable/TheTableHeader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

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

const showSuccessNotification = ref(false)

const showEditModal = () => {}

const showDetailsModal = () => {}

const sort = (field: string) => handleSort(field, params.value)
</script>

<template>
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
                    :filters="[]"
                    :pagination-data="orphans"
                    :params="params"
                    :title="$t('list', { attribute: $t('the_college_students') })"
                    :url="route('tenant.college-students.index')"
                    entries="college_students"
                    export-pdf-url=""
                    export-xlsx-url=""
                    searchable
                    @change-filters="params.filters = $event"
                >
                </the-table-header>

                <template v-if="orphans.data.length > 0">
                    <data-table
                        :orphans
                        :params
                        @sort="sort"
                        @show-edit-modal="showEditModal"
                        @show-details-modal="showDetailsModal"
                    ></data-table>

                    <the-table-footer
                        :pagination-data="orphans"
                        :params
                        :url="route('tenant.college-students.index')"
                        preserve-scroll
                        preserve-state
                    ></the-table-footer>
                </template>

                <the-no-results-table v-else></the-no-results-table>

                <success-notification
                    :open="showSuccessNotification"
                    :title="$tc('successfully_trashed', 0, { attribute: $t('the_demand') })"
                ></success-notification>
            </div>

            <template #fallback>
                <the-content-loader></the-content-loader>
            </template>
        </suspense>
    </div>
</template>
