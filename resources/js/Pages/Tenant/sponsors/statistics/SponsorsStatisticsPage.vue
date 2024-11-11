<script lang="ts" setup>
import type {
    SponsorsByAcademicLevelType,
    SponsorsByDiplomaType,
    SponsorsBySponsorTypeType,
    SponsorsBySponsorshipType
} from '@/types/statistics'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheStatisticBox from '@/Components/Global/TheStatisticBox.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

const SponsorsByAcademicLevel = defineAsyncComponent(
    () => import('@/Pages/Tenant/sponsors/statistics/SponsorsByAcademicLevel.vue')
)

const SponsorsByDiploma = defineAsyncComponent(() => import('@/Pages/Tenant/sponsors/statistics/SponsorsByDiploma.vue'))

const SponsorsBySponsorType = defineAsyncComponent(
    () => import('@/Pages/Tenant/sponsors/statistics/SponsorsBySponsorType.vue')
)

defineOptions({
    layout: TheLayout
})

defineProps<{
    sponsorsBySponsorType: SponsorsBySponsorTypeType
    sponsorsByAcademicLevel: SponsorsByAcademicLevelType
    sponsorsBySponsorship: SponsorsBySponsorshipType
    sponsorsByDiploma: SponsorsByDiplomaType
}>()
</script>

<template>
    <Head :title="$t('statistics', { attribute: $t('the_sponsors') })"></Head>

    <h2 class="intro-y mt-10 text-lg font-medium">{{ $t('statistics.header', { attribute: $t('the_sponsors') }) }}</h2>

    <suspense>
        <div class="intro-y mt-5 grid grid-cols-12 gap-6">
            <!-- Begin: sponsorsBySponsorType -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.sponsors.titles.sponsors_by_sponsor_type') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <sponsors-by-sponsor-type :sponsorsBySponsorType></sponsors-by-sponsor-type>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: sponsorsBySponsorType -->

            <!-- Begin: sponsorsByAcademicLevel -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.sponsors.titles.sponsors_by_academic_level') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <sponsors-by-academic-level :sponsorsByAcademicLevel></sponsors-by-academic-level>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: sponsorsByAcademicLevel -->

            <!-- Begin: sponsorsByDiploma -->
            <div class="col-span-12 lg:col-span-6">
                <the-statistic-box>
                    <template #title> {{ $t('statistics.sponsors.titles.sponsors_by_diploma') }}</template>

                    <template #chart>
                        <suspense suspensible>
                            <sponsors-by-diploma :sponsorsByDiploma></sponsors-by-diploma>
                        </suspense>
                    </template>
                </the-statistic-box>
            </div>
            <!-- End: sponsorsByDiploma -->
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
