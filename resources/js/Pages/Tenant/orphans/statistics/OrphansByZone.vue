<script lang="ts" setup>
import type { OrphansByZoneType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

const BasePolarBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BasePolarBarChart.vue'))

defineProps<{
    orphansByZone: OrphansByZoneType
}>()
</script>

<template>
    <suspense v-if="orphansByZone.data.length" suspensible>
        <base-polar-bar-chart
            :chart-data="orphansByZone.data"
            :labels="orphansByZone.labels"
            hide-legend
        ></base-polar-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
