<script lang="ts" setup>
import type { OrphansByAcademicLevelType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseVerticalBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseVerticalBarChart.vue'))

defineProps<{
    orphansByAcademicLevel: OrphansByAcademicLevelType
}>()
</script>

<template>
    <suspense v-if="orphansByAcademicLevel.data.length" suspensible>
        <base-vertical-bar-chart
            :datasets="[
                {
                    data: orphansByAcademicLevel.data,
                    label: $t('orphans_count')
                }
            ]"
            :height="300"
            :labels="orphansByAcademicLevel.labels"
        ></base-vertical-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
