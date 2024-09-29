<script lang="ts" setup>
import type { SponsorShowType } from '@/types/sponsors'

import { formatCurrency, omit } from '@/utils/helper'

defineProps<{ sponsor: SponsorShowType }>()
</script>

<template>
    <!-- BEGIN: Incomes -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('income information') }}</h2>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div v-for="(income, key) in omit(sponsor.incomes, ['id'])" :key class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t(`incomes.label.${key}`) }}
                </h2>

                <h3 class="text-base font-medium">{{ formatCurrency(income) }}</h3>
            </div>
        </div>
    </div>
    <!-- END: Incomes -->
</template>
