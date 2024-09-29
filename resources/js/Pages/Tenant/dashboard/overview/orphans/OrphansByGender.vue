<script lang="ts" setup>
import type { OrphansByGenderType } from '@/types/dashboard'

import TheReportDonutChart from '@/Components/Global/TheReportDonutChart.vue'

import { sumObjectValues } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{
    orphansByGender: OrphansByGenderType
}>()

const totalOrphans = sumObjectValues(props.orphansByGender.data)
</script>

<template>
    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
        <div class="box zoom-in p-5">
            <div class="flex items-center">
                <div class="w-2/4 flex-none">
                    <div class="truncate text-lg font-medium rtl:font-semibold">
                        {{ $t('statistics.dashboard.orphans_by_gender') }}
                    </div>

                    <div class="mt-1 text-slate-500">
                        {{ $tc('statistics.dashboard.orphans_count', totalOrphans, { count: String(totalOrphans) }) }}
                    </div>
                </div>
                <div class="relative ms-auto flex-none">
                    <the-report-donut-chart
                        :data="orphansByGender.data"
                        :height="90"
                        :labels="orphansByGender.labels.map((key) => $t(key))"
                        :width="90"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
