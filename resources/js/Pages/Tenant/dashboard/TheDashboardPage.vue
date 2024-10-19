<script lang="ts" setup>
import {
    ComingEventsType,
    FamiliesByBranchType,
    FamiliesByZoneType,
    FamiliesForMapType,
    FinancialReportsType,
    GeneralReportsType,
    NeedsByCreatedDateType,
    NeedsByNeedableTypeType,
    OrphansByGenderType,
    OrphansGroupByCreatedDateType,
    RecentActivitiesType,
    RecentFamiliesType,
    RecentNeedsType,
    RecentTransactionsType
} from '@/types/dashboard'
import { PositionType } from '@/types/types'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheFamiliesDistribution from '@/Pages/Tenant/dashboard/families-distribution/TheFamiliesDistribution.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const TheGeneralReports = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/general-reports/TheGeneralReports.vue')
)

const TheFamiliesOverview = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/overview/families/TheFamiliesOverview.vue')
)

const TheNeedsOverview = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/overview/needs/TheNeedsOverview.vue')
)

const TheOrphansOverview = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/overview/orphans/TheOrphansOverview.vue')
)

const TheRecentNeeds = defineAsyncComponent(() => import('@/Pages/Tenant/dashboard/needs/TheRecentNeeds.vue'))

const TheRecentActivities = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/recent-activities/TheRecentActivities.vue')
)

const TheRecentFamilies = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/recent-families/TheRecentFamilies.vue')
)

const TheSchedules = defineAsyncComponent(() => import('@/Pages/Tenant/dashboard/schedules/TheSchedules.vue'))

const TheRecentFinancialTransactions = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/transactions/TheRecentFinancialTransactions.vue')
)

const TheFinancialReport = defineAsyncComponent(
    () => import('@/Pages/Tenant/dashboard/financial-report/TheFinancialReport.vue')
)

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    reports: GeneralReportsType
    financialReports: FinancialReportsType
    recentActivities: RecentActivitiesType
    recentTransactions: RecentTransactionsType
    comingEvents: ComingEventsType
    recentFamilies: RecentFamiliesType
    recentNeeds: RecentNeedsType
    orphansByGender: OrphansByGenderType
    orphansGroupByCreatedDate: OrphansGroupByCreatedDateType
    needsByNeedableType: NeedsByNeedableTypeType
    needsByCreatedDate: NeedsByCreatedDateType
    familiesByZone: FamiliesByZoneType
    familiesByBranch: FamiliesByBranchType
    familiesForMap: FamiliesForMapType[]
}>()
</script>

<template>
    <Head :title="$t('home')" />

    <suspense>
        <div>
            <!--Begin: General Reports-->
            <the-general-reports :reports></the-general-reports>
            <!--End: General Reports-->

            <!--Begin: Financial Reports-->
            <div class="grid grid-cols-12 gap-x-2">
                <suspense v-if="hasPermission('view_financial_transactions')" suspensible>
                    <the-financial-report :financialReports></the-financial-report>
                </suspense>

                <suspense suspensible>
                    <the-families-overview :familiesByBranch :familiesByZone></the-families-overview>
                </suspense>
            </div>
            <!--End: Financial Reports-->

            <!--Begin: Recent Families-->
            <suspense v-if="hasPermission('list_families')" suspensible>
                <the-recent-families :recentFamilies></the-recent-families>
            </suspense>
            <!--End: Recent Families-->

            <!--Begin: Families Distribution-->
            <the-families-distribution :familiesForMap></the-families-distribution>
            <!--End: Families Distribution-->

            <!--Begin: Overview-->
            <div class="col-span-12 mt-8 grid grid-cols-12 gap-6">
                <suspense v-if="hasPermission('list_needs')" suspensible>
                    <the-needs-overview :needsByCreatedDate :needsByNeedableType></the-needs-overview>
                </suspense>

                <suspense v-if="hasPermission('list_orphans')" suspensible>
                    <the-orphans-overview :orphansByGender :orphansGroupByCreatedDate></the-orphans-overview>
                </suspense>
            </div>
            <!--End: Overview -->

            <div class="col-span-12 2xl:col-span-3">
                <div class="-mb-10 pb-10 2xl:border-s">
                    <div class="grid grid-cols-12 gap-x-6 gap-y-6 2xl:gap-x-0 2xl:ps-6">
                        <!--Begin: Recent Financial Transaction-->
                        <suspense v-if="hasPermission('list_financial_transactions')" suspensible>
                            <the-recent-financial-transactions :recentTransactions></the-recent-financial-transactions>
                        </suspense>
                        <!--End: Recent Financial Transaction-->

                        <!--Begin: Recent Activities-->
                        <suspense suspensible>
                            <the-recent-activities :recentActivities></the-recent-activities>
                        </suspense>

                        <!--End: Recent Activities-->

                        <!--Begin: Schedules-->
                        <suspense v-if="hasPermission(['list_lessons', 'view_lessons'])" suspensible>
                            <the-schedules :comingEvents></the-schedules>
                        </suspense>
                        <!--End: Schedules-->

                        <!--Begin: Recent Needs-->
                        <suspense v-if="hasPermission('list_needs')" suspensible>
                            <the-recent-needs :recentNeeds></the-recent-needs>
                        </suspense>
                        <!--End: Recent Needs-->
                    </div>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader class="!mt-24"></the-content-loader>
        </template>
    </suspense>
</template>
