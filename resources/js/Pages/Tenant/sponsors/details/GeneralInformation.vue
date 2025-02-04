<script lang="ts" setup>
import type { SponsorShowType } from '@/types/sponsors'

import TheAttachementsViewer from '@/Components/Global/TheAttachementsViewer.vue'

import { formatDate } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ sponsor: SponsorShowType }>()
</script>

<template>
    <!-- BEGIN: Sponsor Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ sponsor.name }}</h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-success/30 px-2 py-1 text-sm font-semibold text-success dark:bg-darkmode-400"
            >
                {{ $t(`sponsor_types.${sponsor.sponsor_type}`) }}
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('the_branch') }}</h2>

                <h3 class="text-base font-medium">{{ sponsor.branch?.name }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('zone name') }}</h2>

                <h3 class="text-base font-medium">{{ sponsor.zone?.name }}</h3>
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
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.phone_number') }}</h2>

                <h3 class="text-base font-medium">{{ sponsor.phone_number || '————' }}</h3>
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

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('ccp') }}</h2>
                <h3 class="text-base font-medium">{{ sponsor.ccp || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('orphans_count') }}</h2>

                <h3 class="text-base font-medium">{{ sponsor.orphans_count || '————' }}</h3>
            </div>
        </div>
    </div>
    <!-- END: Sponsor Information -->

    <the-attachements-viewer
        :images="sponsor.files.images"
        :no-files-message="$t('no_diploma_or_birth_certificate_or_no_remarriage')"
        :pdf="sponsor.files.pdf"
    ></the-attachements-viewer>
</template>
