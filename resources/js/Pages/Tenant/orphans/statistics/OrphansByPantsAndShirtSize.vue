<script lang="ts" setup>
import type { OrphansByPantsAndShirtSizeType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseVerticalBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseVerticalBarChart.vue'))

defineProps<{
    orphansByPantsAndShirtSize: OrphansByPantsAndShirtSizeType
}>()
</script>

<template>
    <suspense v-if="orphansByPantsAndShirtSize.shirts_data.length" suspensible>
        <base-vertical-bar-chart
            :datasets="[
                {
                    data: orphansByPantsAndShirtSize.shirts_data,
                    label: $t('shirt_size')
                },
                {
                    data: orphansByPantsAndShirtSize.pants_data,
                    label: $t('pants_size')
                }
            ]"
            :height="300"
            :labels="Object.values(orphansByPantsAndShirtSize.labels)"
        ></base-vertical-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
