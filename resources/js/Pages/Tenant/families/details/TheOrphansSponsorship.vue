<script lang="ts" setup>
import { $t } from '@/utils/i18n'

import type { OrphanSponsorshipType } from '@/types/families'

import { Link } from '@inertiajs/vue3'

import NoResultsFound from '@/Components/Global/NoResultsFound.vue'

import { groupByKey } from '@/utils/helper'

const props = defineProps<{ sponsorShips: OrphanSponsorshipType[] }>()

const schoolBagBeneficiaries = groupByKey(props.sponsorShips, 'school_bag')['true']

const medicalSponsorshipBeneficiaries = groupByKey(props.sponsorShips, 'medical_sponsorship')['true']

const eidSuitBeneficiaries = groupByKey(props.sponsorShips, 'eid_suit')['true']

const associationTripsBeneficiaries = groupByKey(props.sponsorShips, 'association_trips')['true']

const privateLessonsBeneficiaries = groupByKey(props.sponsorShips, 'private_lessons')['true']

const summerCampBeneficiaries = groupByKey(props.sponsorShips, 'summer_camp')['true']

const universityScholarshipBeneficiaries = groupByKey(props.sponsorShips, 'university_scholarship')['true']
</script>

<template>
    <!-- BEGIN: Orphans Sponsorships (School Bags) -->
    <div v-if="schoolBagBeneficiaries?.length" class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('sponsorships.school_bags') }}</h2>
        </div>

        <Link
            v-for="beneficiary in schoolBagBeneficiaries"
            :key="beneficiary.id"
            :href="route('tenant.orphans.show', beneficiary.orphan.id)"
            class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
        >
            <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

            <span class="text-base font-semibold">{{ beneficiary.orphan.name }}</span>
        </Link>
    </div>
    <!-- END: Orphans Sponsorships (School Bags) -->

    <!-- BEGIN: Orphans Sponsorships (Private lessons) -->
    <div v-else-if="privateLessonsBeneficiaries?.length" class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('sponsorships.private_lessons') }}</h2>
        </div>

        <Link
            v-for="beneficiary in privateLessonsBeneficiaries"
            :key="beneficiary.id"
            :href="route('tenant.orphans.show', beneficiary.orphan.id)"
            class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
        >
            <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

            <span class="text-base font-semibold">{{ beneficiary.orphan.name }}</span>
        </Link>
    </div>
    <!-- END: Orphans Sponsorships (Private lessons) -->

    <!-- BEGIN: Orphans Sponsorships (Medical Sponsorship) -->
    <div v-else-if="medicalSponsorshipBeneficiaries?.length" class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('sponsorships.medical_sponsorship') }}</h2>
        </div>

        <Link
            v-for="beneficiary in medicalSponsorshipBeneficiaries"
            :key="beneficiary.id"
            :href="route('tenant.orphans.show', beneficiary.orphan.id)"
            class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
        >
            <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

            <span class="text-base font-semibold">{{ beneficiary.orphan.name }}</span>
        </Link>
    </div>
    <!-- END: Orphans Sponsorships (Medical Sponsorship) -->

    <!-- BEGIN: Orphans Sponsorships (Eid Suits) -->
    <div v-else-if="eidSuitBeneficiaries?.length" class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('sponsorships.eid_suit') }}</h2>
        </div>

        <Link
            v-for="beneficiary in eidSuitBeneficiaries"
            :key="beneficiary.id"
            :href="route('tenant.orphans.show', beneficiary.orphan.id)"
            class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
        >
            <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

            <span class="text-base font-semibold">{{ beneficiary.orphan.name }}</span>
        </Link>
    </div>
    <!-- END: Orphans Sponsorships (Eid Suits) -->

    <!-- BEGIN: Orphans Sponsorships (association Trips) -->
    <div v-else-if="associationTripsBeneficiaries?.length" class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('sponsorships.association_trips') }}</h2>
        </div>

        <Link
            v-for="beneficiary in associationTripsBeneficiaries"
            :key="beneficiary.id"
            :href="route('tenant.orphans.show', beneficiary.orphan.id)"
            class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
        >
            <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

            <span class="text-base font-semibold">{{ beneficiary.orphan.name }}</span>
        </Link>
    </div>
    <!-- END: Orphans Sponsorships (association Trips) -->

    <!-- BEGIN: Orphans Sponsorships (summer Camp) -->
    <div v-else-if="summerCampBeneficiaries?.length" class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('sponsorships.summer_camp') }}</h2>
        </div>

        <Link
            v-for="beneficiary in summerCampBeneficiaries"
            :key="beneficiary.id"
            :href="route('tenant.orphans.show', beneficiary.orphan.id)"
            class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
        >
            <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

            <span class="text-base font-semibold">{{ beneficiary.orphan.name }}</span>
        </Link>
    </div>
    <!-- END: Orphans Sponsorships (summer Camp) -->

    <!-- BEGIN: Orphans Sponsorships (university Scholarship) -->
    <div v-else-if="universityScholarshipBeneficiaries?.length" class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">
                {{ $t('sponsorships.university_scholarship') }}
            </h2>
        </div>

        <Link
            v-for="beneficiary in universityScholarshipBeneficiaries"
            :key="beneficiary.id"
            :href="route('tenant.orphans.show', beneficiary.orphan.id)"
            class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
        >
            <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

            <span class="text-base font-semibold">{{ beneficiary.orphan.name }}</span>
        </Link>
    </div>
    <!-- END: Orphans Sponsorships (university Scholarship) -->

    <div v-else class="intro-y col-span-12 flex flex-col items-center justify-center">
        <no-results-found>
            {{ $t('orphans_sponsorship_not_found') }}
        </no-results-found>
    </div>
</template>
