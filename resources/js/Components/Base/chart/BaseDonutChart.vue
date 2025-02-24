<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { borderColor, labelColor } from '@/utils/colors'
import { colorPalette } from '@/utils/constants'
import { getLocale } from '@/utils/i18n'

const props = defineProps<{
    width?: number
    height?: number
    labels: string[]
    chartData: number[]
    hideLegend?: boolean
}>()

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const colors = computed(() => {
    return colorPalette[darkMode.value ? 'dark' : 'light'].sort(() => Math.random() - 0.5)
})

const data = computed<ChartData>(() => {
    return {
        labels: props.labels,
        datasets: [
            {
                data: props.chartData,
                backgroundColor: colors.value,
                borderWidth: 3,
                borderColor: darkMode.value ? borderColor : '#fff'
            }
        ]
    }
})

const options = computed<ChartOptions>(() => {
    return {
        maintainAspectRatio: false,
        plugins: {
            legend: props.hideLegend
                ? { display: false }
                : {
                      labels: {
                          color: labelColor
                      },
                      rtl: getLocale() === 'ar'
                  },

            tooltip: {
                rtl: getLocale() === 'ar'
            }
        },
        cutout: '80%',

        locale: getLocale()
    }
})
</script>

<template>
    <base-chart :data :height :options :width type="doughnut" />
</template>
