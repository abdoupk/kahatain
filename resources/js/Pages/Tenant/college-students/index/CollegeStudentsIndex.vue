<script lang="ts" setup>
import type { IndexParams } from '@/types/types'

import TheLayout from '@/Layouts/TheLayout.vue'

import AcademicPhases from '@/Pages/Tenant/college-students/index/AcademicPhases.vue'
import DataTable from '@/Pages/Tenant/college-students/index/DataTable.vue'
import StudentsChart from '@/Pages/Tenant/college-students/index/StudentsChart.vue'

defineOptions({
    layout: TheLayout
})

defineProps<{
    orphans: unknown
    params: IndexParams
    academicLevels: unknown
    totalCollegeStudents: unknown
    collegeStudentsPerPhase: unknown
    studentsPerUniversity: unknown
}>()
</script>

<template>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Academic Phases -->
        <academic-phases :academicLevels :totalCollegeStudents></academic-phases>
        <!-- END: Academic Phases -->

        <!-- BEGIN: Students Chart -->
        <students-chart :collegeStudentsPerPhase :studentsPerUniversity :totalCollegeStudents></students-chart>
        <!-- END: Students Chart -->

        <data-table :orphans :params></data-table>
    </div>
</template>
