<script lang="ts" setup>
import type { FamiliesByBranchType } from '@/types/dashboard'

import BasePieChart from '@/Components/Base/chart/BasePieChart.vue'
import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

defineProps<{
    familiesByBranch: FamiliesByBranchType
}>()
</script>

<template>
    <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3">
        <div class="intro-y flex h-10 items-center">
            <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">
                {{ $t('statistics.families.titles.families_by_branch') }}
            </h2>
        </div>
        <div class="intro-y box mt-5 p-5">
            <div class="mt-3">
                <base-pie-chart
                    v-if="familiesByBranch.data.length"
                    :chart-data="familiesByBranch.data"
                    :height="336"
                    :labels="familiesByBranch.labels"
                    hide-legend
                ></base-pie-chart>

                <the-no-data-chart v-else class="h-[336px]"></the-no-data-chart>
            </div>
        </div>
    </div>
</template>
