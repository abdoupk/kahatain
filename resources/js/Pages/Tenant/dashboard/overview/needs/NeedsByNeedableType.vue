<script lang="ts" setup>
import type { NeedsByNeedableTypeType } from '@/types/dashboard'

import TheReportDonutChart from '@/Components/Global/TheReportDonutChart.vue'

import { sumObjectValues } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{
    needsByNeedableType: NeedsByNeedableTypeType
}>()

const totalNeeds = sumObjectValues(props.needsByNeedableType.data)
</script>

<template>
    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
        <div class="box zoom-in p-5">
            <div class="flex items-center">
                <div class="w-2/4 flex-none">
                    <div class="truncate text-lg font-medium rtl:font-semibold">
                        {{ $t('statistics.dashboard.needs_by_needable_type') }}
                    </div>

                    <div class="mt-1 text-slate-500">
                        {{
                            $tc('statistics.dashboard.needs_count', totalNeeds, {
                                count: String(totalNeeds)
                            })
                        }}
                    </div>
                </div>
                <div class="relative ms-auto flex-none">
                    <the-report-donut-chart
                        :data="needsByNeedableType.data"
                        :height="90"
                        :labels="needsByNeedableType.labels.map((key) => $t(`the_${key}s`))"
                        :width="90"
                    ></the-report-donut-chart>
                </div>
            </div>
        </div>
    </div>
</template>
