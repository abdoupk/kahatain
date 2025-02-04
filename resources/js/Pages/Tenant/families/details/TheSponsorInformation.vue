<script lang="ts" setup>
import type { SponsorType } from '@/types/families'

import { Link } from '@inertiajs/vue3'

import SponsorIncomes from '@/Pages/Tenant/sponsors/SponsorIncomes.vue'

import TheAttachementsViewer from '@/Components/Global/TheAttachementsViewer.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ sponsor: SponsorType }>()
</script>

<template>
    <!-- BEGIN: Sponsor Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-2 text-xl font-bold">{{ sponsor.name }}</h2>

            <Link
                v-if="hasPermission('edit_sponsors')"
                :href="route('tenant.sponsors.edit', sponsor.id)"
                class="me-auto"
            >
                <svg-loader class="inline h-4 w-4" name="icon-pen"></svg-loader>

                {{ $t('edit') }}
            </Link>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-success/30 px-2 py-1 text-sm font-semibold text-success dark:bg-darkmode-400"
            >
                {{ $t(`sponsor_types.${sponsor.sponsor_type}`) }}
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.phone_number') }}</h2>

                <h3 class="text-base font-medium">{{ sponsor.phone_number || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('ccp') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.ccp || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sponsor.father_name') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.father_name || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sponsor.mother_name') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.mother_name || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sponsor.function') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.function || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sponsor.academic_level') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.academic_level || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sponsor.diploma') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.diploma || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sponsor.health_status') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.health_status || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sponsor.birth_date') }}</h2>
                <h3 class="text-base font-medium">{{ formatDate(sponsor.birth_date, 'long') }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t('validation.attributes.sponsor.birth_certificate_number') }}
                </h2>
                <h3 class="text-base font-medium">{{ sponsor.birth_certificate_number || '————' }}</h3>
            </div>
        </div>
    </div>
    <!-- END: Sponsor Information -->

    <the-attachements-viewer
        :images="sponsor.files.images"
        :no-files-message="$t('no_diploma_or_birth_certificate_or_no_remarriage')"
        :pdf="sponsor.files.pdf"
    ></the-attachements-viewer>

    <!-- BEGIN: Incomes -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('income information') }}</h2>
        </div>

        <sponsor-incomes :sponsor></sponsor-incomes>
    </div>
    <!-- END: Incomes -->

    <the-attachements-viewer
        :images="sponsor.files.images"
        :no-files-message="$t('no_incomes_files_uploaded')"
        :pdf="sponsor.files.pdf"
    ></the-attachements-viewer>
</template>
