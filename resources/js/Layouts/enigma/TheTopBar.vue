<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { Link, usePage } from '@inertiajs/vue3'
import { twMerge } from 'tailwind-merge'

import TheAccountMenu from '@/Components/top-bar/TheAccountMenu/TheAccountMenu.vue'
import TheBreadcrumb from '@/Components/top-bar/TheBreadcrumb.vue'
import TheNotification from '@/Components/top-bar/notifications/TheNotification.vue'
import TheSearch from '@/Components/top-bar/search/TheSearch.vue'

import { isAssociationNameLatin } from '@/utils/helper'

const settingsStore = useSettingsStore()
</script>

<template>
    <div
        :class="
            twMerge([
                'relative z-[51] -mx-5 mt-12 h-[70px] border-b border-white/[0.08] px-3 sm:-mx-8 sm:px-8 md:fixed md:inset-x-0 md:top-0 md:-mx-0 md:mt-0 md:h-[65px] md:border-b-0 md:bg-gradient-to-b md:from-slate-100 md:to-transparent md:px-10 md:pt-10 dark:md:from-darkmode-700',

                'before:absolute before:inset-0 before:top-0 before:mx-7 before:mt-3 before:hidden before:h-[65px] before:rounded-xl before:bg-primary/30 before:content-[\'\'] before:dark:bg-darkmode-600/30 before:md:block',
                'after:absolute after:inset-0 after:mx-3 after:mt-5 after:hidden after:h-[65px] after:rounded-xl after:bg-primary after:shadow-md after:content-[\'\'] after:dark:bg-darkmode-600 after:md:block',

                settingsStore.layout == 'top_menu' && 'dark:md:from-darkmode-800'
            ])
        "
    >
        <div class="flex h-full items-center">
            <Link :href="route('tenant.dashboard')" class="-intro-x hidden items-center md:flex">
                <img :alt="usePage().props.association" class="w-6" src="/images/logo.svg" />

                <span
                    :class="
                        twMerge([
                            'ms-3 flex max-w-40 items-center truncate font-semibold capitalize text-white',
                            settingsStore.layout == 'side_menu' && 'hidden xl:flex',
                            settingsStore.layout == 'simple_menu' && 'hidden',
                            isAssociationNameLatin && 'text-sm',
                            !isAssociationNameLatin && 'text-base'
                        ])
                    "
                >
                    {{ usePage().props.association }}
                </span>
            </Link>

            <the-breadcrumb
                :class="
                    twMerge([
                        '-intro-x me-auto h-[45px] border-white/[0.08] dark:border-white/[0.08] md:ms-10 md:border-s',
                        settingsStore.layout != 'top_menu' && 'md:ps-6',
                        settingsStore.layout == 'top_menu' && 'md:ps-10'
                    ])
                "
                light
            ></the-breadcrumb>

            <the-search></the-search>

            <the-notification></the-notification>

            <the-account-menu></the-account-menu>
        </div>
    </div>
</template>
