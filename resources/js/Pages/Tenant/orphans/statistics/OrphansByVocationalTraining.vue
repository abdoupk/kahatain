<script lang="ts" setup>
import type { OrphansByVocationalTrainingType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseVerticalBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseVerticalBarChart.vue'))

defineProps<{
    orphansByVocationalTraining: OrphansByVocationalTrainingType
}>()
</script>

<template>
    <suspense v-if="orphansByVocationalTraining.data.length" suspensible>
        <base-vertical-bar-chart
            :datasets="[
                {
                    data: orphansByVocationalTraining.data,
                    label: $t('orphans_count')
                }
            ]"
            :height="300"
            :labels="orphansByVocationalTraining.labels"
        ></base-vertical-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
