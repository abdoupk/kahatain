<script lang="ts" setup>
import { FamiliesForMapType } from '@/types/dashboard'

import TheMap from '@/Pages/Tenant/dashboard/families-distribution/TheMap.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    familiesForMap: FamiliesForMapType[]
}>()
</script>

<template>
    <div class="col-span-12 mt-6 xl:col-span-8">
        <div class="intro-y block h-10 items-center sm:flex">
            <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">
                {{ $t('families_distribution') }}
            </h2>
        </div>

        <div class="intro-y box mt-12 p-5 sm:mt-5">
            <the-map :familiesForMap class="h-[350px] rounded-xl" />
        </div>
    </div>
</template>
