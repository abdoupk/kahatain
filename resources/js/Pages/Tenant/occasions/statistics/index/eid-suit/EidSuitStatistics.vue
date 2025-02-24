<script lang="ts" setup>
import { EidSuitStatisticsType } from '@/types/statistics'

import BaseVerticalBarChart from '@/Components/Base/chart/BaseVerticalBarChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

defineProps<{ eidSuit: EidSuitStatisticsType }>()
</script>

<template>
    <base-vertical-bar-chart
        v-if="eidSuit.length"
        :datasets="[
            {
                data: eidSuit.map((d) => d.male_count),
                label: $t('male')
            },
            {
                data: eidSuit.map((d) => d.female_count),
                label: $t('female')
            }
        ]"
        :height="300"
        :labels="eidSuit.map((d) => d.year)"
    ></base-vertical-bar-chart>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
