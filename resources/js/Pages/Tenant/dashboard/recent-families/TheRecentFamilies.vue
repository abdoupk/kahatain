<script lang="ts" setup>
import type { RecentFamiliesType } from '@/types/dashboard'

import { router } from '@inertiajs/vue3'

import TheDesktopView from '@/Pages/Tenant/dashboard/recent-families/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/dashboard/recent-families/TheMobileView.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    recentFamilies: RecentFamiliesType
}>()

const deleteFamily = (id: string) => {
    router.delete(route('tenant.families.destroy', id), {
        preserveScroll: true,
        only: ['recentFamilies']
    })
}
</script>

<template>
    <suspense suspensible>
        <div class="col-span-12 mt-6">
            <div class="intro-y block h-10 items-center sm:flex">
                <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">{{ $t('Recent Added Families') }}</h2>
            </div>
            <div class="@container">
                <the-desktop-view :recent-families @delete-family="deleteFamily"></the-desktop-view>

                <the-mobile-view :recent-families @delete-family="deleteFamily"></the-mobile-view>
            </div>
        </div>
    </suspense>

    <!--        <div class="intro-y mt-8 overflow-auto sm:mt-0 lg:overflow-visible">-->
    <!--            -->
    <!--        </div>-->
</template>
