<script lang="ts" setup>
import type { FamiliesByZoneType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

const BasePieChart = defineAsyncComponent(() => import('@/Components/Base/chart/BasePieChart.vue'))

defineProps<{
    familiesByZone: FamiliesByZoneType
}>()
</script>

<template>
    <suspense v-if="familiesByZone.data?.length" suspensible>
        <base-pie-chart :chart-data="familiesByZone.data" :labels="familiesByZone.labels" hide-legend></base-pie-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
