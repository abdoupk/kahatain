<script lang="ts" setup>
import type { SponsorsByAcademicLevelType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { $t } from '@/utils/i18n'

const BaseVerticalBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseVerticalBarChart.vue'))

defineProps<{
    sponsorsByAcademicLevel: SponsorsByAcademicLevelType
}>()
</script>

<template>
    <suspense v-if="sponsorsByAcademicLevel.data.length" suspensible>
        <base-vertical-bar-chart
            :datasets="[
                {
                    data: sponsorsByAcademicLevel.data,
                    label: $t('sponsors_count')
                }
            ]"
            :height="300"
            :labels="sponsorsByAcademicLevel.labels"
        ></base-vertical-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
