<script lang="ts" setup>
import type { AppearanceType } from '@/types/types'

import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'

const settingsStore = useSettingsStore()

const setDarkModeClass = () => {
    settingsStore.appearance === 'dark'
        ? document.documentElement.classList.add('dark')
        : document.documentElement.classList.remove('dark')
}

const switchMode = (value: AppearanceType) => {
    settingsStore.toggleAppearance(value)

    setDarkModeClass()
}
</script>

<template>
    <div class="px-8 pb-8 pt-6">
        <div class="text-base font-medium">{{ $t('appearance') }}</div>

        <div class="mt-0.5 text-slate-500">{{ $t('theme.appearance_hint') }}</div>

        <div class="mt-5 grid grid-cols-2 gap-3.5">
            <div>
                <a
                    :class="
                        twMerge([
                            'box block h-12 cursor-pointer border-slate-300/80 bg-slate-50 p-1',
                            '[&.active]:border-2 [&.active]:border-theme-1/60',
                            settingsStore?.appearance === 'light' ? 'active' : ''
                        ])
                    "
                    @click.prevent="switchMode('light')"
                >
                    <div class="h-full overflow-hidden rounded-md bg-slate-200"></div>
                </a>
                <div class="mt-2.5 text-center text-xs capitalize">Light</div>
            </div>
            <div>
                <a
                    :class="
                        twMerge([
                            'box block h-12 cursor-pointer border-slate-300/80 bg-slate-50 p-1',
                            '[&.active]:border-2 [&.active]:border-theme-1/60',
                            settingsStore?.appearance === 'dark' ? 'active' : ''
                        ])
                    "
                    @click.prevent="switchMode('dark')"
                >
                    <div class="h-full overflow-hidden rounded-md bg-slate-900"></div>
                </a>
                <div class="mt-2.5 text-center text-xs capitalize">Dark</div>
            </div>
        </div>
    </div>
</template>
