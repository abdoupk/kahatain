<script lang="ts" setup>
import type { OrphansByCreatedDateType } from '@/types/statistics'

import { useSettingsStore } from '@/stores/settings'
import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { extractColor, getColor } from '@/utils/colors'
import { abbreviationMonths } from '@/utils/constants'
import { sumObjectValues } from '@/utils/helper'
import { $t, getLocale } from '@/utils/i18n'

const BaseLineChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseLineChart.vue'))

defineProps<{
    orphansByCreatedDate: OrphansByCreatedDateType
}>()
</script>

<template>
    <suspense v-if="sumObjectValues(Object.values(orphansByCreatedDate))" suspensible>
        <base-line-chart
            :datasets="[
                {
                    data: Object.values(orphansByCreatedDate),
                    label: $t('orphans_count'),
                    borderColor: () =>
                        useSettingsStore().appearance === 'dark'
                            ? getColor('#cbd5e1', 0.6)
                            : extractColor('primary', 0.8)
                }
            ]"
            :height="300"
            :labels="abbreviationMonths[getLocale()]"
        ></base-line-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
