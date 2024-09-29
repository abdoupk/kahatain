<script lang="ts" setup>
import type { OrphansByFamilyStatusType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseRadarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseRadarChart.vue'))

const props = defineProps<{
    orphansByFamilyStatus: OrphansByFamilyStatusType
}>()

const datasets = [
    {
        data: props.orphansByFamilyStatus.data,
        label: $t('statistics.orphans.titles.orphans_by_family_status')
    }
]
</script>

<template>
    <suspense v-if="datasets[0].data.length" suspensible>
        <base-radar-chart :datasets :labels="orphansByFamilyStatus.labels"></base-radar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
