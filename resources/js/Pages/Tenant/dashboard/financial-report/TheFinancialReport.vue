<script lang="ts" setup>
import type { FinancialReportsType } from '@/types/dashboard'

import { router } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheNoDataChart from '@/Components/Global/TheNoDataChart.vue'

import { financialSpecifications } from '@/utils/constants'
import { formatCurrency, sumObjectValues } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BaseFormSelect = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormSelect.vue'))

const ReportLineChart = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/financial-report/ReportLineChart.vue')
)

defineProps<{
    financialReports: FinancialReportsType
}>()

const handleChange = (specification: string) => {
    router.get(
        route('tenant.dashboard'),
        {
            specification
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ['financialReports']
        }
    )
}
</script>

<template>
    <suspense v-if="financialReports.incomes.length" suspensible>
        <div class="col-span-12 mt-8 lg:col-span-6">
            <div class="intro-y block h-10 items-center sm:flex">
                <h2 class="me-5 truncate font-medium rtl:text-xl rtl:font-semibold">
                    {{ $t('statistics.dashboard.financial_report') }}
                </h2>
            </div>

            <div class="intro-y box mt-12 p-5 sm:mt-5">
                <div v-if="sumObjectValues(financialReports.incomes) || sumObjectValues(financialReports.expenses)">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex">
                            <div>
                                <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl">
                                    {{ formatCurrency(financialReports.totalThisMonth) }}
                                </div>

                                <div class="mt-0.5 text-slate-500 ltr:capitalize">{{ $t('this_month') }}</div>
                            </div>

                            <div
                                class="mx-4 h-12 w-px border border-e border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5"
                            ></div>

                            <div>
                                <div class="text-lg font-medium text-slate-500 xl:text-xl">
                                    {{ formatCurrency(financialReports.totalLastMonth) }}
                                </div>
                                <div class="mt-0.5 text-slate-500 ltr:capitalize">{{ $t('last_month') }}</div>
                            </div>
                        </div>

                        <div class="ms-auto">
                            <base-form-select @update:model-value="handleChange">
                                <option value="">{{ $t('all') }}</option>

                                <option v-for="option in financialSpecifications" :key="option" :value="option">
                                    {{ $t(option) }}
                                </option>
                            </base-form-select>
                        </div>
                    </div>

                    <div>
                        <ReportLineChart :financialReports :height="275" class="-mb-6 mt-6" />
                    </div>
                </div>

                <the-no-data-chart v-else class="h-[347px]"></the-no-data-chart>
            </div>
        </div>
    </suspense>
</template>
