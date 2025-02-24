<script lang="ts" setup>
import type { IndexParams, PaginationData, RamadanBasketFamiliesResource } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<RamadanBasketFamiliesResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="family in families.data" :key="family.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        <Link v-if="hasPermission('view_families')" :href="route('tenant.families.show', family.id)">
                            {{ family.sponsor.name }}
                        </Link>

                        <p v-else>{{ family.sponsor.name }}</p>
                    </div>

                    <base-tippy
                        :content="$t('income_rate')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ formatCurrency(family.income_rate) }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('sponsor_phone_number') }}
                        </div>
                        {{ family.sponsor.phone_number }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('filters.amount_from_benefactor') }}
                        </div>
                        {{ formatCurrency(family.amount_from_benefactor) }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('filters.basket_from_benefactor') }}
                        </div>
                        {{ formatCurrency(family.basket_from_benefactor) }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('monthly_sponsorship.difference') }}
                        </div>
                        {{ formatCurrency(family.ramadan_sponsorship_difference) }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('ramadan_basket_category') }}
                        </div>
                        {{ family.ramadan_basket_category }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('orphans_count') }}
                        </div>
                        {{ family.orphans_count }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('validation.attributes.address') }}
                        </div>

                        <base-tippy :content="family.address" class="truncate" dir="rtl"
                            >{{ family.address }}
                        </base-tippy>
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('validation.attributes.zone') }}
                        </div>
                        {{ family.zone?.name }}
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('incomes.label.total_income')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatCurrency(family.total_income) }}
                        </base-tippy>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
