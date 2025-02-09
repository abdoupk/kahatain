<script lang="ts" setup>
import type { SponsorsByDiplomaType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

const BaseDonutChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseDonutChart.vue'))

defineProps<{
    sponsorsByDiploma: SponsorsByDiplomaType
}>()
</script>

<template>
    <suspense v-if="sponsorsByDiploma.data.length" suspensible>
        <base-donut-chart
            :chart-data="sponsorsByDiploma.data"
            :labels="sponsorsByDiploma.labels"
            hide-legend
        ></base-donut-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
