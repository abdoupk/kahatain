<script lang="ts" setup>
import { EidAlAdhaStatisticsType } from '@/types/statistics'

import BasePieChart from '@/Components/Base/chart/BasePieChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{ eidAlAdha: EidAlAdhaStatisticsType }>()

const datasets = props.eidAlAdha.length && [
    {
        data: Object.values(props.eidAlAdha[0]),
        label: $t('statistics.occasions.titles.eid_al_adha')
    }
]
</script>

<template>
    <suspense v-if="datasets && datasets[0].data.length && eidAlAdha.length" suspensible>
        <base-pie-chart
            :chart-data="Object.values(eidAlAdha[0])"
            :labels="eidAlAdha.length ? Object.keys(eidAlAdha[0]).map((key) => $t(key)) : []"
        ></base-pie-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
