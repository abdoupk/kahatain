<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { ChartData, ChartOptions } from 'chart.js/auto'
import { computed, defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { getColor } from '@/utils/colors'
import { getLocale } from '@/utils/i18n'

const BaseChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseChart.vue'))

const props = defineProps<{
    width?: number
    height?: number
    lineColor?: string
    labels: string[]
    datasets: {
        label: string
        data: number[]
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
                borderColor: !darkMode.value ? getColor('primary', 0.8) : getColor('#94a3b8', 0.8),
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
                border: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 12
                    },
                    color: getColor('#64748b', 0.8)
                },
                grid: {
                    display: false
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
                    color: getColor('#64748b', 0.8),
                    callback: function (value: number) {
                        if (value % 1 === 0) {
                            return value
                        }
                    }
                },
                grid: {
                    drawTicks: false,
                    color: darkMode.value ? getColor('#64748b', 0.3) : getColor('#cbd5e1')
                }
            }
        },

        locale: getLocale()
    }
})
</script>

<template>
    <suspense v-if="data.datasets[0].data.length" suspensible>
        <base-chart :data :height :options :width type="line" />
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
