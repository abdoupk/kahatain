<script lang="ts" setup>
import type { CalculationTableType } from '@/types/settings'
import type { SiteSettingsType } from '@/types/types'

import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import ThePreDefinedAwardedForm from '@/Pages/Tenant/settings/ThePreDefinedAwardedForm.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

const TheExportData = defineAsyncComponent(() => import('@/Pages/Tenant/settings/TheExportData.vue'))

const TheCalculationTable = defineAsyncComponent(() => import('@/Pages/Tenant/settings/TheCalculationTable.vue'))

const TheTenantInfosUpdateForm = defineAsyncComponent(
    () => import('@/Pages/Tenant/settings/TheTenantInfosUpdateForm.vue')
)

defineOptions({
    layout: TheLayout
})

defineProps<{
    settings: SiteSettingsType
    calculation: CalculationTableType
}>()
</script>

<template>
    <Head :title="$t('settings')"></Head>

    <suspense>
        <div>
            <h2 class="intro-y mt-10 text-lg font-medium">{{ $t('settings') }}</h2>

            <div class="intro-y mt-5 grid grid-cols-12 gap-6">
                <the-tenant-infos-update-form :settings></the-tenant-infos-update-form>

                <the-export-data></the-export-data>

                <the-calculation-table :calculation></the-calculation-table>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
