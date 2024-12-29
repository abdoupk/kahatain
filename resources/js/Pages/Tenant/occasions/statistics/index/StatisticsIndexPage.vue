<script lang="ts" setup>
import {
    BabiesMilkAndDiapersStatisticsType,
    EidAlAdhaStatisticsType,
    EidSuitStatisticsType,
    MeatDistributionStatisticsType,
    MonthlySponsorshipStatisticsType,
    RamadanBasketStatisticsType,
    SchoolEntryStatisticsType,
    ZakatStatisticsType
} from '@/types/statistics'

import { router } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
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

const props = defineProps<{
    babiesMilkAndDiapers: BabiesMilkAndDiapersStatisticsType
    ramadanBasket: RamadanBasketStatisticsType
    eidSuit: EidSuitStatisticsType
    eidAlAdha: EidAlAdhaStatisticsType
    schoolEntry: SchoolEntryStatisticsType
    monthlySponsorship: MonthlySponsorshipStatisticsType
    zakat: ZakatStatisticsType
    meatDistribution: MeatDistributionStatisticsType
    minMaxDate: {
        min_year: string
        max_year: string
    }
}>()

const dateRanges = Array.from(
    { length: props.minMaxDate.max_year - props.minMaxDate.min_year + 1 },
    (_, i) => props.minMaxDate.min_year + i
)

const handleChangeDateForBabiesMilkAndDiapers = (value) => {
    router.get(
        route('tenant.occasions.statistics'),
        {
            babies_milk_and_diapers_year: value
        },
        {
            preserveScroll: true,
            preserveState: true,
            only: ['babiesMilkAndDiapers']
        }
    )
}

const handleChangeDateForEidAlAdha = (value) => {
    router.get(
        route('tenant.occasions.statistics'),
        {
            eid_al_adha_year: value
        },
        {
            preserveScroll: true,
            preserveState: true,
            only: ['eidAlAdha']
        }
    )
}

const handleChangeDateForZakat = (value) => {
    router.get(
        route('tenant.occasions.statistics'),
        {
            zakat_year: value
        },
        {
            preserveScroll: true,
            preserveState: true,
            only: ['zakat']
        }
    )
}

const handleChangeDateForMonthlySponsorship = (value) => {
    router.get(
        route('tenant.occasions.statistics'),
        {
            monthly_sponsorship_year: value
        },
        {
            preserveScroll: true,
            preserveState: true,
            only: ['monthlySponsorship']
        }
    )
}

const handleChangeDateForMeatDistribution = (value) => {
    router.get(
        route('tenant.occasions.statistics'),
        {
            meat_distribution_year: value
        },
        {
            preserveScroll: true,
            preserveState: true,
            only: ['meatDistribution']
        }
    )
}
</script>

<template>
    <h2 class="intro-y mt-10 text-lg font-medium">{{ $t('statistics.header', { attribute: $t('the_projects') }) }}</h2>

    <suspense>
        <div class="intro-y mt-5 grid grid-cols-12 gap-6">
            <!-- Begin: babiesMilkAndDiapers -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title>
                        {{ $t('statistics.occasions.titles.babies_milk_and_diapers') }}
                    </template>

                    <template #actions>
                        <base-form-select
                            v-model="route().params.babies_milk_and_diapers_year"
                            class="w-1/2"
                            formSelectSize="sm"
                            @update:model-value="handleChangeDateForBabiesMilkAndDiapers"
                        >
                            <option v-for="option in dateRanges" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </base-form-select>
                    </template>

                    <template #chart>
                        <suspense suspensible>
                            <babies-milk-and-diapers-statistics
                                :babiesMilkAndDiapers
                            ></babies-milk-and-diapers-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: babiesMilkAndDiapers -->

            <!-- Begin: eidSuit -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title>
                        {{ $t('statistics.occasions.titles.eid_suit') }}
                    </template>

                    <template #chart>
                        <suspense suspensible>
                            <eid-suit-statistics :eidSuit></eid-suit-statistics>
                        </suspense>

                        <div class="h-[0.375rem]"></div>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: eidSuit -->

            <!-- Begin: eidAlAdha -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.eid_al_adha') }}</template>

                    <template #actions>
                        <base-form-select
                            v-model="route().params.eid_al_adha_year"
                            class="w-1/2"
                            formSelectSize="sm"
                            @update:model-value="handleChangeDateForEidAlAdha"
                        >
                            <option v-for="option in dateRanges" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </base-form-select>
                    </template>

                    <template #chart>
                        <suspense suspensible>
                            <eid-al-adha-statistics :eidAlAdha></eid-al-adha-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: eidAlAdha -->

            <!-- Begin: zakat -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.zakat') }}</template>

                    <template #actions>
                        <base-form-select
                            v-model="route().params.zakat_year"
                            class="w-1/2"
                            formSelectSize="sm"
                            @update:model-value="handleChangeDateForZakat"
                        >
                            <option v-for="option in dateRanges" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </base-form-select>
                    </template>

                    <template #chart>
                        <suspense suspensible>
                            <zakat-statistics :zakat></zakat-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: zakat -->

            <!-- Begin: monthlySponsorship -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.monthly_sponsorship') }}</template>

                    <template #actions>
                        <base-form-select
                            v-model="route().params.monthly_sponsorship_year"
                            class="w-1/2"
                            formSelectSize="sm"
                            @update:model-value="handleChangeDateForMonthlySponsorship"
                        >
                            <option v-for="option in dateRanges" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </base-form-select>
                    </template>

                    <template #chart>
                        <suspense suspensible>
                            <monthly-sponsorship-statistics :monthlySponsorship></monthly-sponsorship-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: monthlySponsorship -->

            <!-- Begin: ramadanBasket -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.ramadan_basket') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <ramadan-basket-statistics :ramadanBasket></ramadan-basket-statistics>
                        </suspense>

                        <div class="h-[0.375rem]"></div>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: ramadanBasket -->

            <!-- Begin: meatDistribution -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.occasions.titles.meat_distribution') }}</template>

                    <template #actions>
                        <base-form-select
                            v-model="route().params.meat_distribution_year"
                            class="w-1/2"
                            formSelectSize="sm"
                            @update:model-value="handleChangeDateForMeatDistribution"
                        >
                            <option v-for="option in dateRanges" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </base-form-select>
                    </template>

                    <template #chart>
                        <suspense suspensible>
                            <meat-distribution-statistics :meatDistribution></meat-distribution-statistics>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: meatDistribution -->

            <!-- Begin: schoolEntry -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title>
                        {{ $t('statistics.occasions.titles.school_entry') }}
                    </template>

                    <template #chart>
                        <suspense suspensible>
                            <school-entry-statistics :schoolEntry></school-entry-statistics>
                        </suspense>

                        <div class="h-[0.375rem]"></div>
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
