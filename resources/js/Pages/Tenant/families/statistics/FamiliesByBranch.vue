<script lang="ts" setup>
import type { FamiliesByBranchType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

const BasePieChart = defineAsyncComponent(() => import('@/Components/Base/chart/BasePieChart.vue'))

defineProps<{
    familiesByBranch: FamiliesByBranchType
}>()
</script>

<template>
    <suspense v-if="familiesByBranch.data.length" suspensible>
        <base-pie-chart :chart-data="familiesByBranch.data" :labels="familiesByBranch.labels"></base-pie-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
