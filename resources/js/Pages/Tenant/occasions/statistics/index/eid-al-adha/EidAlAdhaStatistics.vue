<script lang="ts" setup>
import { EidAlAdhaStatisticsType } from '@/types/statistics'

import BaseRadarChart from '@/Components/Base/chart/BaseRadarChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{ eidAlAdha: EidAlAdhaStatisticsType }>()

const datasets = props.eidAlAdha.length && [
    {
        data: Object.values(props.eidAlAdha[0]),
        label: $t('statistics.orphans.titles.orphans_by_family_status')
    }
]
</script>

<template>
    <suspense v-if="datasets && datasets[0].data.length" suspensible>
        <base-radar-chart :datasets :labels="Object.keys(eidAlAdha[0])"></base-radar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
