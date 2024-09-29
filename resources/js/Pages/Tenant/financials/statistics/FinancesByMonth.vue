<script lang="ts" setup>
import type { FinancesByMonthType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { sumObjectValues } from '@/utils/helper'

const ReportLineChart = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/financial-report/ReportLineChart.vue')
)

defineProps<{
    financesByMonth: FinancesByMonthType
}>()
</script>

<template>
    <suspense v-if="sumObjectValues(financesByMonth.incomes) || sumObjectValues(financesByMonth.expenses)" suspensible>
        <ReportLineChart :financialReports="financesByMonth" :height="300"></ReportLineChart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
