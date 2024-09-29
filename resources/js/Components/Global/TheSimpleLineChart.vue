<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { extractColor } from '@/utils/colors'
import { abbreviationMonths } from '@/utils/constants'
import { getLocale } from '@/utils/i18n'

const props = defineProps<{
    width?: number
    height?: number
    lineColor?: string
    data: number[]
    label?: string
}>()

const colorScheme = computed(() => useSettingsStore().colorScheme)

const data = computed<ChartData>(() => {
    return {
        // eslint-disable-next-line array-element-newline
        labels: abbreviationMonths[getLocale()],
        datasets: [
            {
                label: props.label,
                // eslint-disable-next-line array-element-newline
                data: props.data,
                borderWidth: 2,
                borderColor:
                    colorScheme.value && props.lineColor?.length ? props.lineColor : extractColor('primary', 0.8),
                backgroundColor: 'transparent',
                pointBorderColor: 'transparent',
                tension: 0.4
            }
        ]
    }
})

const options = computed<ChartOptions>(() => {
    return {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
                rtl: getLocale() === 'ar'
            },
            tooltip: {
                rtl: getLocale() === 'ar'
            }
        },
        scales: {
            x: {
                reverse: getLocale() === 'ar',
                display: false,
                ticks: {
                    display: false
                },
                grid: {
                    display: false
                }
            },
            y: {
                position: getLocale() === 'ar' ? 'right' : 'left',
                display: false,
                ticks: {
                    display: false
                },
                grid: {
                    display: false
                }
            }
        },
        locale: getLocale()
    }
})
</script>

<template>
    <base-chart :data="data" :height="props.height" :options="options" :width="props.width" type="line" />
</template>
