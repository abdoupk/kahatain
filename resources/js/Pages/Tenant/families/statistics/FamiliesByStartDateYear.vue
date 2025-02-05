<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { abbreviationMonths } from '@/utils/constants'
import { sumObjectValues } from '@/utils/helper'
import { $t, getLocale } from '@/utils/i18n'

const FamiliesByStartDateThisYearChart = defineAsyncComponent(
    () => import('@/Pages/Tenant/families/statistics/FamiliesByStartDateThisYearChart.vue')
)

defineProps<{
    familiesGroupByDate: number[]
}>()
</script>

<template>
    <suspense v-if="sumObjectValues(Object.values(familiesGroupByDate))" suspensible>
        <families-by-start-date-this-year-chart
            :datasets="[
                {
                    data: Object.values(familiesGroupByDate),
                    label: $t('families_count')
                }
            ]"
            :height="270"
            :labels="abbreviationMonths[getLocale()]"
        ></families-by-start-date-this-year-chart>
    </suspense>

    <the-no-data-chart v-else class="!min-h-[270px]"></the-no-data-chart>
</template>
