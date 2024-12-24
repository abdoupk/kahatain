<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheStatisticBox from '@/Components/Global/TheStatisticBox.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

const BabiesMilkAndDiapersStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/babies-milk-and-diapers/BabiesMilkAndDiapersStatistics.vue')
)

const EidAlAdhaStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/eid-al-adha/EidAlAdhaStatistics.vue')
)

const EidSuitStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/eid-suit/EidSuitStatistics.vue')
)

const MeatDistributionStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/meat-distribution/MeatDistributionStatistics.vue')
)

const MonthlySponsorshipStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/monthly-sponsorship/MonthlySponsorshipStatistics.vue')
)

const RamadanBasketStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/ramadan-basket/RamadanBasketStatistics.vue')
)

const SchoolEntryStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/school-entry/SchoolEntryStatistics.vue')
)

const ZakatStatistics = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/statistics/index/zakat/ZakatStatistics.vue')
)

defineOptions({
    layout: TheLayout
})
</script>

<template>
    <h2 class="intro-y mt-10 text-lg font-medium">{{ $t('statistics.header', { attribute: $t('the_projects') }) }}</h2>

    <suspense>
        <div class="intro-y mt-5 grid grid-cols-12 gap-6">
            <!-- Begin: babiesMilkAndDiapers -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <babies-milk-and-diapers-statistics></babies-milk-and-diapers-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: babiesMilkAndDiapers -->

            <!-- Begin: eidSuit -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <eid-suit-statistics></eid-suit-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: eidSuit -->

            <!-- Begin: eidAlAdha -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <eid-al-adha-statistics></eid-al-adha-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: eidAlAdha -->

            <!-- Begin: zakat -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <zakat-statistics></zakat-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: zakat -->

            <!-- Begin: monthlySponsorship -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <monthly-sponsorship-statistics></monthly-sponsorship-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: monthlySponsorship -->

            <!-- Begin: ramadanBasket -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <ramadan-basket-statistics></ramadan-basket-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: ramadanBasket -->

            <!-- Begin: meatDistribution -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <meat-distribution-statistics></meat-distribution-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: meatDistribution -->

            <!-- Begin: schoolEntry -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <school-entry-statistics></school-entry-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: schoolEntry -->
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
