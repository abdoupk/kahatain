<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'
import { onMounted } from 'vue'

import { setDarkModeClass } from '@/utils/helper'
import { $t } from '@/utils/i18n'

onMounted(() => {
    setDarkModeClass(useSettingsStore().appearance)
})
</script>

<template>
    <div
        :class="
            twMerge([
                'relative h-screen bg-primary p-3 dark:bg-darkmode-800 sm:px-8 lg:overflow-hidden xl:bg-white xl:dark:bg-darkmode-600',
                'before:absolute before:inset-y-0 before:start-0 before:-mb-[16%] before:-ms-[13%] before:-mt-[28%] before:hidden before:w-[57%] before:rotate-[-4.5deg] before:transform before:rounded-[100%] before:bg-primary/20 before:content-[\'\'] before:dark:bg-darkmode-400 before:xl:block',
                'after:absolute after:inset-y-0 after:start-0 after:-mb-[13%] after:-ms-[13%] after:-mt-[20%] after:hidden after:w-[57%] after:rotate-[-4.5deg] after:transform after:rounded-[100%] after:bg-primary after:content-[\'\'] after:dark:bg-darkmode-700 after:xl:block'
            ])
        "
    >
        <div class="container relative z-10 sm:px-10">
            <div class="block grid-cols-2 gap-4 xl:grid">
                <!-- BEGIN: Login Info -->
                <div class="hidden min-h-screen flex-col xl:flex">
                    <a class="-intro-x flex items-center pt-5" href="/">
                        <img alt="Tinker Starter" class="w-6" src="/images/logo.svg" />

                        <span class="ms-3 text-lg text-white"> Kafil el yatim </span>
                    </a>

                    <div class="my-auto">
                        <img alt="Tinker Starter" class="-intro-x -mt-16 w-1/2" src="/images/man-illustration.svg" />
                        <div
                            class="-intro-x mt-10 text-4xl font-medium leading-tight text-white"
                            v-html="$t('auth.hints.leading')"
                        ></div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">
                            {{ $t('auth.hints.second') }}
                        </div>
                    </div>
                </div>
                <!-- END: Login Info -->

                <slot></slot>
            </div>
        </div>
    </div>
</template>
