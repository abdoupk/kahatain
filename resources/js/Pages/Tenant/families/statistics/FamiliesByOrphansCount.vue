<script lang="ts" setup>
import type { FamiliesByOrphansCountType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t, $tc } from '@/utils/i18n'

const BaseVerticalBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseVerticalBarChart.vue'))

const props = defineProps<{
    familiesByOrphansCount: FamiliesByOrphansCountType
}>()

const labels = props.familiesByOrphansCount.orphans_count.map((orphan) =>
    $tc('statistics.families.labels.orphans_count', orphan, {
        value: String(orphan)
    })
)

const datasets = [
    {
        label: $t('families_count'),
        data: props.familiesByOrphansCount.total_families
    }
]
</script>

<template>
    <suspense v-if="datasets[0].data.length" suspensible>
        <base-vertical-bar-chart :datasets :height="270" :labels />
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
