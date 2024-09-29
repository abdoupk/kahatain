<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'

import { colorSchemes } from '@/utils/constants'

const settingsStore = useSettingsStore()

const theAccentColor = defineModel('theAccentColor')

theAccentColor.value = settingsStore.colorScheme
</script>

<template>
    <div class="mt-5">
        <div class="rtl:text-lg rtl:font-semibold">{{ $t('theme.accent_color') }}</div>

        <div class="mt-0.5 text-slate-500">{{ $t('theme.accent_color_hint') }}</div>

        <div class="mt-5 flex justify-start">
            <template v-for="colorScheme in colorSchemes" :key="colorScheme">
                <div class="relative ms-2 flex justify-center gap-4 first:ms-0">
                    <button
                        :class="
                            twMerge([
                                theAccentColor === colorScheme ? 'ring-2' : '',
                                '[&.active]:border-2 [&.active]:border-theme-1/60',
                                colorScheme === settingsStore.colorScheme ? 'active' : '',
                                ['bg-theme-1 dark:bg-theme-2', colorScheme]
                            ])
                        "
                        class="block h-8 w-8 rounded-full ring-primary ring-offset-1 transition-all hover:ring-2 dark:ring-darkmode-400"
                        type="button"
                        @click="theAccentColor = colorScheme"
                    ></button>
                </div>
            </template>
        </div>
    </div>
</template>
