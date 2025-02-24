<script lang="ts" setup>
import type {
    OrphansByAcademicLevelType,
    OrphansByAgeType,
    OrphansByBranchType,
    OrphansByCreatedDateType,
    OrphansByFamilyStatusType,
    OrphansByGenderType,
    OrphansByPantsAndShirtSizeType,
    OrphansByShoeSizeType,
    OrphansByZoneType,
    OrphansGroupHealthStatusType
} from '@/types/statistics'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheStatisticBox from '@/Components/Global/TheStatisticBox.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

const OrphansByAcademicLevel = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/statistics/OrphansByAcademicLevel.vue')
)

const OrphansByAge = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/statistics/OrphansByAge.vue'))

const OrphansByBranch = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/statistics/OrphansByBranch.vue'))

const OrphansByCreatedDate = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/statistics/OrphansByCreatedDate.vue')
)

const OrphansByFamilyStatus = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/statistics/OrphansByFamilyStatus.vue')
)

const OrphansByGender = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/statistics/OrphansByGender.vue'))

const OrphansByPantsAndShirtSize = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/statistics/OrphansByPantsAndShirtSize.vue')
)

const OrphansByShoeSize = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/statistics/OrphansByShoeSize.vue'))

const OrphansByZone = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/statistics/OrphansByZone.vue'))

const OrphansGroupHealthStatus = defineAsyncComponent(
    () => import('@/Pages/Tenant/orphans/statistics/OrphansGroupHealthStatus.vue')
)

defineOptions({
    layout: TheLayout
})

defineProps<{
    orphansByFamilyStatus: OrphansByFamilyStatusType
    orphansByAcademicLevel: OrphansByAcademicLevelType
    orphansByGender: OrphansByGenderType
    orphansByAge: OrphansByAgeType
    orphansByZone: OrphansByZoneType
    orphansByBranch: OrphansByBranchType
    orphansByPantsAndShirtSize: OrphansByPantsAndShirtSizeType
    orphansByShoeSize: OrphansByShoeSizeType
    orphansByCreatedDate: OrphansByCreatedDateType
    orphansGroupHealthStatus: OrphansGroupHealthStatusType
}>()
</script>

<template>
    <Head :title="$t('statistics', { attribute: $t('the_orphans') })"></Head>

    <h2 class="intro-y mt-10 text-lg font-medium">{{ $t('statistics.header', { attribute: $t('the_orphans') }) }}</h2>

    <suspense>
        <div class="intro-y mt-5 grid grid-cols-12 gap-6">
            <!-- Begin: orphansByFamilyStatus -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_family_status') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-family-status :orphansByFamilyStatus></orphans-by-family-status>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByFamilyStatus -->

            <!-- Begin: orphansByAcademicLevel -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_academic_level') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-academic-level :orphansByAcademicLevel></orphans-by-academic-level>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByAcademicLevel -->

            <!-- Begin: orphansByGender -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_gender') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-gender :orphansByGender></orphans-by-gender>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByGender -->

            <!-- Begin: orphansByAge -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_age') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-age :orphansByAge></orphans-by-age>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByAge -->

            <!-- Begin: orphansByZone -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_zone') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-zone :orphansByZone></orphans-by-zone>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByZone -->

            <!-- Begin: orphansByBranch -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_branch') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-branch :orphansByBranch></orphans-by-branch>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByBranch -->

            <!-- Begin: orphansByPantsAndShirtSize -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_pants_and_shirt_size') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-pants-and-shirt-size
                                :orphansByPantsAndShirtSize
                            ></orphans-by-pants-and-shirt-size>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByPantsAndShirtSize -->

            <!-- Begin: orphansByShoeSize -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_shoe_size') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-shoe-size :orphansByShoeSize></orphans-by-shoe-size>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByShoeSize -->

            <!-- Begin: orphansByCreatedDate -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_by_created_date') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-by-created-date :orphansByCreatedDate></orphans-by-created-date>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansByCreatedDate -->

            <!-- Begin: orphansGroupHealthStatus -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.orphans.titles.orphans_group_health_status') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <orphans-group-health-status :orphansGroupHealthStatus></orphans-group-health-status>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: orphansGroupHealthStatus -->
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
