<script lang="ts" setup>
import type { OrphansBySponsorshipType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { sumObjectValues } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BasePolarBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BasePolarBarChart.vue'))

defineProps<{
    orphansBySponsorship: OrphansBySponsorshipType
}>()
</script>

<template>
    <suspense v-if="sumObjectValues(Object.values(orphansBySponsorship))" suspensible>
        <base-polar-bar-chart
            :chart-data="Object.values(orphansBySponsorship)"
            :labels="Object.keys(orphansBySponsorship).map((key) => $t(key))"
        ></base-polar-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
