<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'

import { themes } from '@/utils/constants'

const settingsStore = useSettingsStore()
</script>

<template>
    <div class="px-8 pb-8 pt-6">
        <div class="text-base font-medium">{{ $t('theme.themes') }}</div>

        <div class="mt-0.5 text-slate-500">{{ $t('theme.theme_hint') }}</div>

        <div class="mt-5 grid grid-cols-2 gap-x-5 gap-y-3.5">
            <template v-for="theme in themes" :key="theme">
                <div @click.prevent="settingsStore.changeTheme(theme)">
                    <div
                        :class="
                            twMerge([
                                'box block h-28 cursor-pointer bg-slate-50 p-1',
                                settingsStore?.theme === theme
                                    ? 'border-2 border-theme-1/60 dark:border-darkmode-50'
                                    : ''
                            ])
                        "
                    >
                        <div class="image-fit h-full w-full overflow-hidden rounded-md">
                            <img :alt="theme" :src="`/images/themes/${theme}.png`" class="h-full w-full" />
                        </div>
                    </div>
                    <div class="mt-2.5 text-center text-xs capitalize">
                        {{ theme }}
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
