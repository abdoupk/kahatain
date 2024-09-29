<script lang="ts" setup>
import type { FinancesByTypeType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { getColor } from '@/utils/colors'
import { abbreviationMonths } from '@/utils/constants'
import { $t, getLocale } from '@/utils/i18n'

const BaseLineChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseLineChart.vue'))

defineProps<{
    financesByType: FinancesByTypeType
}>()
</script>

<template>
    <suspense v-if="financesByType.incomes.length || financesByType.expenses.length" suspensible>
        <base-line-chart
            :datasets="[
                {
                    data: financesByType.incomes,
                    borderColor: () => getColor('primary', 0.5),
                    label: $t('statistics.finances.incomes')
                },
                {
                    data: financesByType.expenses,
                    borderColor: () => getColor('primary', 0.5),
                    label: $t('statistics.finances.expenses')
                }
            ]"
            :height="300"
            :labels="abbreviationMonths[getLocale()]"
        ></base-line-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
