<script lang="ts" setup>
import { AcademicLevelsIndexResource } from '@/types/lessons'
import { StudentsPerInstitution, StudentsPerPhase } from '@/types/orphans'

import TheLayout from '@/Layouts/TheLayout.vue'

import AcademicPhases from '@/Pages/Tenant/students/index/AcademicPhases.vue'
import StudentsChart from '@/Pages/Tenant/students/index/StudentsChart.vue'

defineOptions({
    layout: TheLayout
})

defineProps<{
    academicLevels: AcademicLevelsIndexResource
    totalStudents: number
    studentsPerPhase: StudentsPerPhase
    studentsPerSchool: StudentsPerInstitution
}>()
</script>

<template>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Academic Phases -->
        <academic-phases :academicLevels :totalStudents></academic-phases>
        <!-- END: Academic Phases -->

        <!-- BEGIN: Students Chart -->
        <students-chart :studentsPerPhase :studentsPerSchool :totalStudents></students-chart>
        <!-- END: Students Chart -->
    </div>
</template>
