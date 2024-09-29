<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { gridDarkColor, labelColor } from '@/utils/colors'
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
                backgroundColor: generateRandomColor()
            }
        })
    }
})

const options = computed<ChartOptions>(() => {
    return {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: labelColor
                },
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
                    color: labelColor
                },
                grid: {
                    color: darkMode.value ? gridDarkColor : gridDarkColor,
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
    <base-chart :data :height :options :width type="bar" />
</template>
