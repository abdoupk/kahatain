<script lang="ts" setup>
import type { FamilyShowType } from '@/types/families'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheAttachementsViewer from '@/Components/Global/TheAttachementsViewer.vue'

import { formatCurrency, formatDate } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ family: FamilyShowType }>()
</script>

<template>
    <!-- BEGIN: General Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ family.name }}</h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-sm font-semibold text-slate-400 dark:bg-darkmode-400 rtl:!font-semibold"
            >
                {{ formatDate(family.start_date, 'long') }}
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('validation.attributes.file_number') }}
                </h2>

                <h3 class="text-base">
                    {{ family.file_number || '————' }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('validation.attributes.branch_id') }}
                </h2>

                <h3 class="truncate text-base">
                    <base-tippy v-if="family.branch" :content="family.branch">
                        {{ family.branch }}
                    </base-tippy>

                    <span v-else>————</span>
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('validation.attributes.zone') }}
                </h2>

                <h3 class="text-base">{{ family.zone }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('validation.attributes.address') }}

                    <!--                    <span class="cursor-pointer" @click.prevent="showMap">-->
                    <!--                        <svg-loader class="ms-2 inline" name="icon-map-location-dot"></svg-loader>-->
                    <!--                    </span>-->
                </h2>

                <h3 class="text-base">{{ family.address }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.total_income') }}
                </h2>

                <h3 class="text-base">{{ formatCurrency(family.total_income) }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('income_rate') }}
                </h2>

                <h3 class="text-base">{{ formatCurrency(family.income_rate) }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.difference_before_monthly_sponsorship') }}
                </h2>

                <h3 class="text-base">
                    {{ formatCurrency(family.difference_before_monthly_sponsorship) }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.difference_after_monthly_sponsorship') }}
                </h2>

                <h3 class="text-base">
                    {{ formatCurrency(family.difference_after_monthly_sponsorship) }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.amount_from_association') }}
                </h2>

                <h3 class="text-base">
                    {{ formatCurrency(family.amount_from_association) }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.basket_from_association') }}
                </h2>

                <h3 class="text-base">
                    {{ family.basket_from_association ? $t('yes') : $t('no') }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.basket_from_benefactor') }}
                </h2>

                <h3 class="text-base">
                    {{ formatCurrency(family.basket_from_benefactor) }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.amount_from_benefactor') }}
                </h2>

                <h3 class="text-base">
                    {{ formatCurrency(family.amount_from_benefactor) }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('monthly_sponsorship.monthly_sponsorship_rate') }}
                </h2>

                <h3 class="text-base">{{ family.monthly_sponsorship_rate }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('aggregate_red_meat_benefit') }}
                </h2>

                <h3 class="text-base">
                    {{ family.aggregate_red_meat_benefit }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('aggregate_white_meat_benefit') }}
                </h2>

                <h3 class="text-base">
                    {{ family.aggregate_white_meat_benefit }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('aggregate_zakat_benefit') }}
                </h2>

                <h3 class="text-base">
                    {{ formatCurrency(family.aggregate_zakat_benefit) }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('filters.ramadan_basket_category') }}
                </h2>

                <h3 class="text-base">
                    {{ family.ramadan_basket_category }}
                </h3>
            </div>
        </div>
    </div>
    <!-- END: General Information -->

    <!-- Begin: Display Residence File   -->

    <the-attachements-viewer
        :images="family.files.images"
        :no-files-message="$t('no_residence_certificate')"
        :pdf="family.files.pdf"
    ></the-attachements-viewer>
    <!-- End: Display Residence File   -->
</template>
