<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { borderColor, getColor, labelColor } from '@/utils/colors'
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
    return colorPalette[darkMode.value ? 'dark' : 'light']
})

const data = computed<ChartData>(() => {
    return {
        labels: props.labels,
        datasets: [
            {
                data: props.chartData,
                backgroundColor: colors.value,
                borderWidth: 0,
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
                      rtl: getLocale() === 'ar',
                      labels: {
                          color: labelColor
                      }
                  },
            tooltip: {
                rtl: getLocale() === 'ar'
            }
        },

        scales: {
            r: {
                suggestedMin: 0,
                grid: {
                    tickColor: 'rgba(255, 255, 255, 0.0)',
                    color: !darkMode.value ? getColor('#64748b', 0.3) : getColor('#94a3b8', 0.8)
                },
                ticks: {
                    font: {
                        size: 12
                    },
                    color: darkMode.value ? getColor('#cbd5e1', 0.8) : getColor('#475569', 0.8),
                    backdropColor: 'rgba(255, 255, 255, 0.0)',
                    callback(tickValue: number) {
                        if (tickValue % 1 === 0) {
                            return tickValue
                        }
                    }
                }
            }
        },

        cutout: '65%',

        locale: getLocale()
    }
})
</script>

<template>
    <base-chart :data :height :options :width type="polarArea" />
</template>
