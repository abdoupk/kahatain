<script lang="ts" setup>
import type { FamilyShowType } from '@/types/families'

import TheAttachementsViewer from '@/Components/Global/TheAttachementsViewer.vue'

import { formatDate } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ family: FamilyShowType }>()
</script>

<template>
    <!-- BEGIN: General Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ family.name }}</h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-sm font-semibold text-slate-400 dark:bg-darkmode-400"
            >
                {{ formatDate(family.start_date, 'long') }}
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.file_number') }}</h2>
                <h3 class="text-base font-medium">{{ family.file_number || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.branch_id') }}</h2>
                <h3 class="text-base font-medium">{{ family.branch }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.zone') }}</h2>
                <h3 class="text-base font-medium">{{ family.zone }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.address') }}</h2>
                <h3 class="text-base font-medium">{{ family.address }}</h3>
            </div>
        </div>
    </div>
    <!-- END: General Information -->

    <!-- Begin: Display Residence File   -->

    <the-attachements-viewer
        :images="family.files.images"
        :no-files-message="$t('no_residence_certificate')"
        :pdf="family.files.pdf"
    ></the-attachements-viewer>
    <!-- End: Display Residence File   -->
</template>
