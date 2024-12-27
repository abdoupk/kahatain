<script lang="ts" setup>
import { MeatDistributionStatisticsType } from '@/types/statistics'

import { useSettingsStore } from '@/stores/settings'

import BaseLineChart from '@/Components/Base/chart/BaseLineChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { extractColor, getColor } from '@/utils/colors'
import { abbreviationMonths } from '@/utils/constants'
import { sumObjectValues } from '@/utils/helper'
import { $t, getLocale } from '@/utils/i18n'

defineProps<{ meatDistribution: MeatDistributionStatisticsType }>()
</script>

<template>
    <suspense v-if="sumObjectValues(Object.values(meatDistribution))" suspensible>
        <base-line-chart
            :datasets="[
                {
                    data: Object.values(meatDistribution),
                    label: $t('babies_count'),
                    borderColor: () =>
                        useSettingsStore().appearance === 'dark'
                            ? getColor('#cbd5e1', 0.6)
                            : extractColor('primary', 0.8)
                }
            ]"
            :height="300"
            :labels="abbreviationMonths[getLocale()]"
        ></base-line-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
