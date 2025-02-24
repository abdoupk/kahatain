<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { gridDarkColor, gridLightColor, labelColor } from '@/utils/colors'
import { getLocale } from '@/utils/i18n'

const props = defineProps<{
    width?: number
    height?: number
    lineColor?: string
    labels: string[]
    callback?: (tickValue: number) => string
    datasets: {
        label: string
        data: number[]
        borderColor: () => string
    }[]
}>()

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const data = computed<ChartData>(() => {
    return {
        labels: props.labels,
        datasets: props.datasets.map((dataset) => {
            return {
                label: dataset.label,
                data: dataset.data,
                borderWidth: 2,
                borderColor: dataset.borderColor(),
                backgroundColor: 'transparent',
                pointBorderColor: 'transparent',
                tension: 0.4
            }
        })
    }
})

const options = computed<ChartOptions>(() => {
    return {
        maintainAspectRatio: false,

        plugins: {
            legend: {
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
            x: {
                reverse: getLocale() === 'ar',
                ticks: {
                    font: {
                        size: 12
                    },
                    color: labelColor
                },
                grid: {
                    display: false,
                    drawBorder: false
                }
            },
            y: {
                border: {
                    display: false,
                    dash: [2, 2]
                },
                position: getLocale() === 'ar' ? 'right' : 'left',
                ticks: {
                    font: {
                        size: 12
                    },
                    color: labelColor,
                    callback: props?.callback
                },
                grid: {
                    color: darkMode.value ? gridDarkColor : gridLightColor,
                    borderDash: [2, 2],
                    drawBorder: false
                }
            }
        },

        locale: getLocale()
    }
})
</script>

<template>
    <base-chart :data :height :options :width type="line" />
</template>
