<script lang="ts" setup>
import type { FinancesBySpecificationType } from '@/types/statistics'

import { useSettingsStore } from '@/stores/settings'
import { computed, defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { extractColor, getColor } from '@/utils/colors'
import { sumObjectValues } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BaseRadarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseRadarChart.vue'))

defineProps<{
    financesBySpecification: FinancesBySpecificationType
}>()

const darkMode = computed(() => useSettingsStore().appearance === 'dark')
</script>

<template>
    <suspense
        v-if="sumObjectValues(financesBySpecification.expenses) || sumObjectValues(financesBySpecification.incomes)"
        suspensible
    >
        <base-radar-chart
            :datasets="[
                {
                    data: Object.values(financesBySpecification.incomes),
                    label: $t('incomes'),
                    backgroundColor: () => (!darkMode ? extractColor('primary', 0.5) : getColor('#b1e28c', 0.5)),
                    borderColor: () => (!darkMode ? extractColor('primary', 0.5) : getColor('#b1e28c', 0.3)),
                    pointHoverBorderColor: () => (!darkMode ? extractColor('primary', 0.5) : getColor('#b1e28c', 0.5)),
                    pointBackgroundColor: () => (!darkMode ? extractColor('primary', 0.5) : getColor('#b1e28c', 0.5))
                },
                {
                    data: Object.values(financesBySpecification.expenses),
                    label: $t('expenses'),
                    backgroundColor: () => getColor('#f87171', 0.5),
                    borderColor: () => getColor('#f87171', 0.3),
                    pointHoverBorderColor: () => getColor('#f87171', 0.5),
                    pointBackgroundColor: () => getColor('#f87171', 0.5)
                }
            ]"
            :labels="Object.keys(financesBySpecification.incomes).map((key) => $t(key))"
        ></base-radar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
