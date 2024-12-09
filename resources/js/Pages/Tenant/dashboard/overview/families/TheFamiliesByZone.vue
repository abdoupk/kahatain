<script lang="ts" setup>
import type { FamiliesByZoneType } from '@/types/dashboard'

import BasePolarBarChart from '@/Components/Base/chart/BasePolarBarChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

defineProps<{
    familiesByZone: FamiliesByZoneType
}>()
</script>

<template>
    <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3">
        <div class="intro-y flex h-10 items-center">
            <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">
                {{ $t('statistics.families.titles.families_by_zone') }}
            </h2>
        </div>
        <div class="intro-y box mt-5 p-5">
            <div class="mt-3">
                <base-polar-bar-chart
                    v-if="familiesByZone.data.length"
                    :chart-data="familiesByZone.data"
                    :height="336"
                    :labels="familiesByZone.labels"
                    hide-legend
                ></base-polar-bar-chart>

                <the-no-data-chart v-else class="h-[336px]"></the-no-data-chart>
            </div>
        </div>
    </div>
</template>
