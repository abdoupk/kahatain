<script lang="ts" setup>
import type { OrphansByAgeType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseHorizontalBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseHorizontalBarChart.vue'))

defineProps<{
    orphansByAge: OrphansByAgeType
}>()
</script>

<template>
    <suspense v-if="orphansByAge.data.length" suspensible>
        <base-horizontal-bar-chart
            :datasets="[
                {
                    data: orphansByAge.data,
                    label: $t('orphans_count')
                }
            ]"
            :height="300"
            :labels="orphansByAge.age"
        ></base-horizontal-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
