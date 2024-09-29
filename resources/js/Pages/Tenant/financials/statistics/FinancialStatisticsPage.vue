<script lang="ts" setup>
import type { FinancesByMonthType, FinancesBySpecificationType, FinancesByTypeType } from '@/types/statistics'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheStatisticBox from '@/Components/Global/TheStatisticBox.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

const FinancesByMonth = defineAsyncComponent(() => import('@/Pages/Tenant/financials/statistics/FinancesByMonth.vue'))

const FinancesBySpecification = defineAsyncComponent(
    () => import('@/Pages/Tenant/financials/statistics/FinancesBySpecification.vue')
)

defineOptions({
    layout: TheLayout
})

defineProps<{
    financesBySpecification: FinancesBySpecificationType
    financesByType: FinancesByTypeType
    financesByMonth: FinancesByMonthType
}>()
</script>

<template>
    <Head :title="$t('statistics', { attribute: $t('the_financial_transactions') })"></Head>

    <h2 class="intro-y mt-10 text-lg font-medium">
        {{ $t('statistics.header', { attribute: $t('the_financial_transactions') }) }}
    </h2>

    <suspense>
        <div class="intro-y mt-5 grid grid-cols-12 gap-6">
            <!-- Begin: financesByMonth -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.finances.titles.finances_by_month') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <finances-by-month :financesByMonth></finances-by-month>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: financesByMonth -->

            <!-- Begin: financesByType -->
            <!--            <div class="col-span-12 lg:col-span-6">-->
            <!--                <the-statistic-box>-->
            <!--                    <template #title> {{ $t('statistics.finances.titles.finances_by_type') }}</template>-->

            <!--                    <template #chart>-->
            <!--                        <suspense suspensible>-->
            <!--                            <finances-by-type :financesByType></finances-by-type>-->
            <!--                        </suspense>-->
            <!--                    </template>-->
            <!--                </the-statistic-box>-->
            <!--            </div>-->
            <!-- End: financesByType -->

            <!-- Begin: financesBySpecification -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.finances.titles.finances_by_specification') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <finances-by-specification :financesBySpecification></finances-by-specification>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: financesBySpecification -->
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
