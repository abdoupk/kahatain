<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { extractColor, getColor } from '@/utils/colors'
import { getLocale } from '@/utils/i18n'

const props = defineProps<{
    data: number[]
    labels: string[]
    width?: number
    height?: number
}>()

const colorScheme = computed(() => useSettingsStore().colorScheme)

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

// eslint-disable-next-line array-element-newline
const chartColors = () => [extractColor('pending', 0.9), extractColor('warning', 0.9), extractColor('primary', 0.9)]

const data = computed<ChartData>(() => {
    return {
        labels: props.labels,
        datasets: [
            {
                data: props.data,
                backgroundColor: colorScheme.value ? chartColors() : '',
                hoverBackgroundColor: colorScheme.value ? chartColors() : '',
                borderWidth: 5,
                borderColor: darkMode.value ? extractColor('darkmode-700') : getColor('white')
            }
        ]
    }
})

const options = computed<ChartOptions>(() => {
    return {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                rtl: getLocale() === 'ar'
            }
        },
        cutout: '80%'
    }
})
</script>

<template>
    <base-chart :data :height :options :width type="doughnut" />
</template>
