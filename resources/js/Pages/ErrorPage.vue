<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{
    status: number
    tenantDontFound?: boolean
}>()

const title = computed(() => {
    return {
        503: $t('errors.titles.503'),
        500: $t('errors.titles.500'),
        404: $t('errors.titles.404'),
        403: $t('errors.titles.403')
    }[props.status]
})

const description = computed(() => {
    return {
        503: $t('errors.descriptions.503'),
        500: $t('errors.descriptions.500'),
        404: $t('errors.descriptions.404'),
        403: $t('errors.descriptions.403')
    }[props.status]
})

function getUrlWithoutSubdomain() {
    const url = new URL(window.location.href)

    const hostnameParts = url.hostname.split('.')

    // Get the last two parts of the hostname
    const domain = hostnameParts.slice(-2).join('.')

    return `${url.protocol}//${domain}`
}
</script>

<template>
    <Head :title="$t(`http-statuses.${String(status)}`)"></Head>

    <div class="bg-gradient-to-b from-theme-1 to-theme-2 py-2 dark:from-darkmode-800 dark:to-darkmode-800">
        <div class="container">
            <!-- BEGIN: Error Page -->
            <div
                class="error-page flex h-screen flex-col items-center justify-center text-center lg:flex-row lg:text-start"
            >
                <div class="-intro-x lg:me-20">
                    <img alt="" class="h-48 w-[450px] lg:h-auto" src="/images/error-illustration.svg" />
                </div>

                <div class="mt-10 text-white lg:mt-0">
                    <div class="intro-x text-8xl font-medium">{{ status }}</div>

                    <div class="intro-x mt-5 text-xl font-medium lg:text-3xl rtl:font-semibold">{{ title }}</div>

                    <div class="intro-x mt-3 text-lg">
                        {{ description }}
                    </div>

                    <base-button
                        :as="tenantDontFound ? 'a' : Link"
                        :href="!tenantDontFound ? '/' : getUrlWithoutSubdomain()"
                        class="intro-x mt-10 border-white px-4 py-3 text-white dark:border-darkmode-400 dark:text-slate-200"
                    >
                        {{ $t('errors.back to home') }}
                    </base-button>
                </div>
            </div>
            <!-- END: Error Page -->
        </div>
    </div>
</template>
