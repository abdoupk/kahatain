<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { colorPalette } from '@/utils/constants'
import { addOpacityToHexColor, getRandomItemWithoutRepeat } from '@/utils/helper'
import { getLocale } from '@/utils/i18n'

const props = defineProps<{
    width?: number
    height?: number
    labels: string[] | number[]
    datasets: {
        label: string
        data: number[]
        backgroundColor?: () => string
    }[]
}>()

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const generateRandomColor = () => {
    return addOpacityToHexColor(getRandomItemWithoutRepeat(colorPalette[darkMode.value ? 'dark' : 'light']), 0.6)
}

const data = computed<ChartData>(() => {
    return {
        labels: props.labels,
        datasets: props.datasets.map((dataset) => {
            return {
                label: dataset.label,
                data: dataset.data,
                backgroundColor: dataset.backgroundColor?.() ?? generateRandomColor()
            }
        })
    }
})

const options = computed<ChartOptions>(() => {
    return {
        maintainAspectRatio: false,

        plugins: {
            legend: {
                rtl: getLocale() === 'ar'
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
                    }
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
                    callback(tickValue: number) {
                        return tickValue % 1 === 0 ? tickValue : ''
                    },
                    font: {
                        size: 12
                    }
                },
                grid: {
                    tickBorderDash: false,
                    color:
                        useSettingsStore().appearance === 'dark' ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
                }
            }
        },

        locale: getLocale()
    }
})
</script>

<template>
    <base-chart :data :height :options :width type="bubble" />
</template>
