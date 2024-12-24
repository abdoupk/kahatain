<script lang="ts" setup>
import TheLayout from '@/Layouts/TheLayout.vue'

import AcademicPhases from '@/Pages/Tenant/trainees/index/AcademicPhases.vue'
import TraineesChart from '@/Pages/Tenant/trainees/index/TraineesChart.vue'

defineProps<{
    academicLevels: unknown
    totalTrainees: unknown
    traineesPerPhase: unknown
    traineesPerInstitution: unknown
}>()

defineOptions({
    layout: TheLayout
})
</script>

<template>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Academic Phases -->
        <academic-phases :academicLevels :totalTrainees></academic-phases>
        <!-- END: Academic Phases -->

        <!-- BEGIN: Trainees Chart -->
        <trainees-chart :totalTrainees :traineesPerInstitution :traineesPerPhase></trainees-chart>
        <!-- END: Trainees Chart -->
    </div>
</template>
