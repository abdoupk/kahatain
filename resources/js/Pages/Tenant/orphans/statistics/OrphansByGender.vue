<script lang="ts" setup>
import type { OrphansByGenderType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseDonutChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseDonutChart.vue'))

defineProps<{
    orphansByGender: OrphansByGenderType
}>()
</script>

<template>
    <suspense v-if="orphansByGender.data.length" suspensible>
        <base-donut-chart
            :chart-data="orphansByGender.data"
            :labels="orphansByGender.labels.map((key) => $t(key))"
        ></base-donut-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
