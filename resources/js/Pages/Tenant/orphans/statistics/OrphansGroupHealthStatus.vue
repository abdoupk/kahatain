<script lang="ts" setup>
import type { OrphansGroupHealthStatusType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

const BaseDonutChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseDonutChart.vue'))

defineProps<{
    orphansGroupHealthStatus: OrphansGroupHealthStatusType
}>()
</script>

<template>
    <suspense v-if="orphansGroupHealthStatus.data.length" suspensible>
        <base-donut-chart :chart-data="orphansGroupHealthStatus.data" :labels="orphansGroupHealthStatus.labels" />
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
