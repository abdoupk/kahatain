<script lang="ts" setup>
import type { SpouseType } from '@/types/families'

import TheAttachementsViewer from '@/Components/Global/TheAttachementsViewer.vue'

import { formatCurrency, formatDate } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ deceased: SpouseType[] }>()
</script>

<template>
    <!-- BEGIN: Spouse Information -->
    <div v-for="spouse in deceased" :key="spouse.id" class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ spouse.name }}</h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-sm font-semibold text-slate-400 dark:bg-darkmode-400"
            >
                {{ $t(spouse.type) }}
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.spouse.birth_date') }}</h2>
                <h3 class="text-base font-medium">{{ formatDate(spouse.birth_date, 'long') }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.spouse.death_date') }}</h2>
                <h3 class="text-base font-medium">{{ formatDate(spouse.death_date, 'long') }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.spouse.function') }}</h2>
                <h3 class="text-base font-medium">{{ spouse.function || '————' }}</h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.spouse.income') }}</h2>
                <h3 class="text-base font-medium">{{ formatCurrency(spouse.income) }}</h3>
            </div>
        </div>
    </div>
    <!-- END: Spouse Information -->

    <the-attachements-viewer
        v-for="spouse in deceased"
        :key="spouse.id"
        :images="spouse.files?.images"
        :no-files-message="$t('no_death_certificate')"
        :pdf="spouse.files?.pdf"
    ></the-attachements-viewer>
</template>
