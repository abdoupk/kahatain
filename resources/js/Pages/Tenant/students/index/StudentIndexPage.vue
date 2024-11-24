<script lang="ts" setup>
import AcademicPhases from '@/Pages/Tenant/students/index/AcademicPhases.vue'
import StudentsChart from '@/Pages/Tenant/students/index/StudentsChart.vue'
</script>

<template>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Academic Phases -->
        <academic-phases></academic-phases>
        <!-- END: Academic Phases -->

        <!-- BEGIN: Students Chart -->
        <students-chart></students-chart>
        <!-- END: Students Chart -->
    </div>
</template>
