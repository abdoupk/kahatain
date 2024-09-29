<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { extractColor, getColor } from '@/utils/colors'
import { getLocale } from '@/utils/i18n'

const props = defineProps<{
    width?: number
    height?: number
    lineColor?: string
    labels: string[]
    datasets: {
        label: string
        data: number[]
        borderColor?: () => string
        backgroundColor?: () => string
        pointBackgroundColor?: () => string
        pointHoverBorderColor?: () => string
    }[]
}>()

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const data = computed<ChartData>(() => {
    return {
        labels: props.labels,
        datasets: props.datasets.map((dataset) => {
            return {
                data: dataset.data,
                label: dataset.label,
                fill: true,
                backgroundColor: dataset.backgroundColor?.() ?? extractColor('primary', 0.4),
                borderColor: dataset.borderColor?.() ?? extractColor('primary', 0.5),
                pointBackgroundColor: dataset.pointBackgroundColor?.() ?? extractColor('primary', 0.5),
                pointBorderColor: darkMode.value ? getColor('#64748b', 0.3) : getColor('#cbd5e1'),
                pointHoverBackgroundColor: darkMode.value ? getColor('#64748b', 0.3) : getColor('#cbd5e1'),
                pointHoverBorderColor: dataset.pointHoverBorderColor?.() ?? extractColor('primary', 0.5)
            }
        })
    }
})

const options = computed<ChartOptions>(() => {
    return {
        elements: {
            line: {
                borderWidth: 2
            }
        },
        plugins: {
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
        locale: getLocale()
    }
})
</script>

<template>
    <base-chart :data :height :options :width type="radar" />
</template>
