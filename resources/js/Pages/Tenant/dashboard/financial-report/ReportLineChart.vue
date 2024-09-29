<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { ChartData, ChartOptions } from 'chart.js/auto'
import { computed } from 'vue'

import BaseChart from '@/Components/Base/chart/BaseChart.vue'

import { extractColor, getColor, labelColor } from '@/utils/colors'
import { abbreviationMonths } from '@/utils/constants'
import { formatCurrency } from '@/utils/helper'
import { getLocale } from '@/utils/i18n'

const props = defineProps<{
    width?: number
    height?: number
    financialReports: {
        incomes: number[]
        expenses: number[]
    }
}>()

const colorScheme = computed(() => useSettingsStore().colorScheme)

const darkMode = computed(() => useSettingsStore().appearance === 'dark')

const data = computed<ChartData>(() => {
    return {
        labels: abbreviationMonths[getLocale()],
        datasets: [
            {
                label: '# of Votes',
                data: props.financialReports.incomes,
                borderWidth: 2,
                borderColor: colorScheme.value ? extractColor('primary', 0.8) : '',
                backgroundColor: 'transparent',
                pointBorderColor: 'transparent',
                tension: 0.4
            },
            {
                label: '# of Votes',
                data: props.financialReports.expenses,
                borderWidth: 2,
                borderDash: [2, 2],
                borderColor: darkMode.value ? getColor('#94a3b8', 0.6) : getColor('#94a3b8'),
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
                border: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 12
                    },
                    color: labelColor
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
                    color: labelColor,
                    callback: function (value) {
                        return formatCurrency(value)
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
    <base-chart :data="data" :height="props.height" :options="options" :width="props.width" type="line" />
</template>
