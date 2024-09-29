<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'

import { themes } from '@/utils/constants'

const settingsStore = useSettingsStore()

const theTheme = defineModel('theTheme')

theTheme.value = settingsStore.theme
</script>

<template>
    <h3 class="rtl:text-lg rtl:font-semibold">{{ $t('theme.theme') }}</h3>

    <h4 class="mt-0.5 text-slate-500">{{ $t('theme.theme_hint') }}</h4>

    <div class="mt-5 grid grid-cols-2 gap-x-5 gap-y-3.5 md:grid-cols-4">
        <template v-for="theme in themes" :key="theme">
            <div>
                <div
                    :class="
                        twMerge([
                            'box block h-28 cursor-pointer bg-slate-50 p-1',
                            theTheme === theme ? 'border-2 border-theme-1/60 dark:border-darkmode-50' : ''
                        ])
                    "
                    @click.prevent="theTheme = theme"
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
</template>
