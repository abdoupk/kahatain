<script lang="ts" setup>
import type { SponsorShowType } from '@/types/sponsors'

import SponsorIncomes from '@/Pages/Tenant/sponsors/SponsorIncomes.vue'

import TheAttachementsViewer from '@/Components/Global/TheAttachementsViewer.vue'

import { $t } from '@/utils/i18n'

defineProps<{ sponsor: SponsorShowType }>()
</script>

<template>
    <!-- BEGIN: Incomes -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('income information') }}</h2>
        </div>

        <sponsor-incomes :sponsor></sponsor-incomes>
    </div>
    <!-- END: Incomes -->

    <the-attachements-viewer
        :images="sponsor.incomes.files.images"
        :no-files-message="$t('no_files_uploaded')"
        :pdf="sponsor.incomes.files.pdf"
    ></the-attachements-viewer>
</template>
