<script lang="ts" setup>
import type { FamiliesHousingType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseRadarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseRadarChart.vue'))

const props = defineProps<{
    familiesHousing: FamiliesHousingType
}>()

const datasets = [
    {
        label: $t('housing.label.type'),
        data: props.familiesHousing.data
    }
]
</script>

<template>
    <suspense v-if="datasets[0].data.length" suspensible>
        <div class="flex items-center justify-center">
            <base-radar-chart :datasets :height="300" :labels="familiesHousing.labels" :width="300"></base-radar-chart>
        </div>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
