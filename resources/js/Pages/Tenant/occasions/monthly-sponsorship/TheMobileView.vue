<script lang="ts" setup>
import type { IndexParams, MonthlySponsorshipFamiliesResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<MonthlySponsorshipFamiliesResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="family in families.data" :key="family.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        <Link
                            v-if="family.sponsor.id"
                            :href="route('tenant.sponsors.show', family.sponsor.id)"
                            class="font-medium"
                        >
                            {{ family.sponsor.name }}
                        </Link>
                        <p class="mt-0.5 text-sm text-slate-500">{{ family.sponsor.phone_number }}</p>
                    </div>

                    <base-tippy
                        :content="$t('income_rate')"
                        class="ms-auto flex h-fit w-fit cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ formatCurrency(family.income_rate) }}
                    </base-tippy>
                </div>

                <div class="mt-4 flex">
                    <div class="w-3/4">
                        <p class="truncate">{{ family.address }}</p>
                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            <Link
                                :href="route('tenant.zones.index') + `?show=${family.zone?.id}`"
                                class="whitespace-nowrap text-slate-500"
                            >
                                {{ family.zone?.name }}
                            </Link>
                        </div>
                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            <base-tippy :content="$t('incomes.label.total_income')">
                                {{ formatCurrency(family.total_income) }}
                            </base-tippy>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
