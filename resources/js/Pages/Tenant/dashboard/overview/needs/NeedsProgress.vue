<script lang="ts" setup>
import type { NeedsByCreatedDateType } from '@/types/dashboard'

import TheSimpleLineChart from '@/Components/Global/TheSimpleLineChart.vue'

import { sumObjectValues } from '@/utils/helper'

defineProps<{
    needsByCreatedDate: NeedsByCreatedDateType
}>()
</script>

<template>
    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
        <div class="box zoom-in p-5">
            <div class="flex">
                <div class="me-3 truncate text-lg font-medium rtl:font-semibold">
                    {{ $t('statistics.dashboard.total_needs') }}
                </div>
                <div
                    class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                >
                    {{ sumObjectValues(needsByCreatedDate) }}
                </div>
            </div>
            <div class="mt-1">
                <the-simple-line-chart
                    :data="Object.values(needsByCreatedDate)"
                    :height="58"
                    :label="$t('needs')"
                    class="-ms-1"
                ></the-simple-line-chart>
            </div>
        </div>
    </div>
</template>
