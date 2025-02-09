<script lang="ts" setup>
import type { OrphansByBranchType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

const BasePieChart = defineAsyncComponent(() => import('@/Components/Base/chart/BasePieChart.vue'))

defineProps<{
    orphansByBranch: OrphansByBranchType
}>()
</script>

<template>
    <suspense v-if="orphansByBranch.data.length" suspensible>
        <base-pie-chart
            :chart-data="orphansByBranch.data"
            :labels="orphansByBranch.labels"
            hide-legend
        ></base-pie-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
