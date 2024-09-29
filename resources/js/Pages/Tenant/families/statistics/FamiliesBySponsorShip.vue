<script lang="ts" setup>
import type { FamiliesSponsorShipsType } from '@/types/statistics'

import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { sumObjectValues } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BaseRadarChart = defineAsyncComponent(() => import('@/Components/Base/chart/BaseRadarChart.vue'))

const props = defineProps<{
    familiesSponsorShips: FamiliesSponsorShipsType
}>()

const labels = [
    $t('sponsorships.ramadan_basket'),
    $t('sponsorships.zakat'),
    $t('sponsorships.housing_assistance'),
    $t('sponsorships.eid_al_adha')
]

const datasets = [
    {
        label: $t('sponsorship_type'),
        data: Object.values(props.familiesSponsorShips)
    }
]
</script>

<template>
    <suspense v-if="sumObjectValues(Object.values(familiesSponsorShips))" suspensible>
        <div class="flex items-center justify-center">
            <base-radar-chart :datasets :height="400" :labels :width="400" />
        </div>
    </suspense>

    <the-no-data-chart v-else></the-no-data-chart>
</template>
