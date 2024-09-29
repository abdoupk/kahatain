<script lang="ts" setup>
import type { SponsorsBySponsorshipType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { sumObjectValues } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BasePolarBarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BasePolarBarChart.vue'))

defineProps<{
    sponsorsBySponsorship: SponsorsBySponsorshipType
}>()
</script>

<template>
    <suspense v-if="sumObjectValues(Object.values(sponsorsBySponsorship))" suspensible>
        <base-polar-bar-chart
            :chart-data="Object.values(sponsorsBySponsorship)"
            :labels="Object.keys(sponsorsBySponsorship).map((key) => $t(key))"
        ></base-polar-bar-chart>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
