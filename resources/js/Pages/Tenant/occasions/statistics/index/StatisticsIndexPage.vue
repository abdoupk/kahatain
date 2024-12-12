<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

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
    <babies-milk-and-diapers-statistics></babies-milk-and-diapers-statistics>
    <eid-suit-statistics></eid-suit-statistics>
    <eid-al-adha-statistics></eid-al-adha-statistics>
    <monthly-sponsorship-statistics></monthly-sponsorship-statistics>
    <ramadan-basket-statistics></ramadan-basket-statistics>
    <meat-distribution-statistics></meat-distribution-statistics>
    <school-entry-statistics></school-entry-statistics>
    <zakat-statistics></zakat-statistics>
</template>
