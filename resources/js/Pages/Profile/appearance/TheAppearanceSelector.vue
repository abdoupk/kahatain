<script lang="ts" setup>
import type { AppearanceType } from '@/types/types'

import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'

const settingsStore = useSettingsStore()

const appearance = defineModel('appearance')

appearance.value = settingsStore.appearance

const changeAppearance = (value: AppearanceType) => {
    appearance.value = value

    settingsStore.appearance = value
}
</script>

<template>
    <div class="mt-5">
        <div class="rtl:text-lg rtl:font-semibold">{{ $t('theme.appearance') }}</div>

        <div class="mt-0.5 text-slate-500">{{ $t('theme.appearance_hint') }}</div>

        <div class="mt-5 grid grid-cols-2 gap-3.5">
            <div>
                <div
                    :class="
                        twMerge([
                            '[&.active]:border-2 [&.active]:border-theme-1/60  dark:[&.active]:border-primary',
                            appearance === 'light' ? 'active' : ''
                        ])
                    "
                    class="cursor-pointer items-center rounded-md border-2 p-1"
                    @click.prevent="changeAppearance('light')"
                >
                    <div class="space-y-2 rounded-sm bg-[#ecedef] p-2">
                        <div class="space-y-2 rounded-md bg-white p-2 shadow-sm">
                            <div class="h-2 w-20 rounded-lg bg-[#ecedef]" />
                            <div class="h-2 w-[100px] rounded-lg bg-[#ecedef]" />
                        </div>
                        <div class="flex items-center space-x-2 rounded-md bg-white p-2 shadow-sm">
                            <div class="h-4 w-4 rounded-full bg-[#ecedef]" />
                            <div class="h-2 w-[100px] rounded-lg bg-[#ecedef]" />
                        </div>
                        <div class="flex items-center space-x-2 rounded-md bg-white p-2 shadow-sm">
                            <div class="h-4 w-4 rounded-full bg-[#ecedef]" />
                            <div class="h-2 w-[100px] rounded-lg bg-[#ecedef]" />
                        </div>
                    </div>
                </div>

                <div class="mt-2.5 text-center text-xs capitalize">{{ $t('light_mode') }}</div>
            </div>
            <div>
                <div
                    :class="
                        twMerge([
                            '[&.active]:border-2 [&.active]:border-theme-1/60 dark:[&.active]:border-primary',
                            appearance === 'dark' ? 'active' : ''
                        ])
                    "
                    class="cursor-pointer items-center rounded-md border-2 p-1"
                    @click.prevent="changeAppearance('dark')"
                >
                    <div class="space-y-2 rounded-sm bg-slate-950 p-2">
                        <div class="space-y-2 rounded-md bg-slate-800 p-2 shadow-sm">
                            <div class="h-2 w-20 rounded-lg bg-slate-400" />
                            <div class="h-2 w-[100px] rounded-lg bg-slate-400" />
                        </div>
                        <div class="flex items-center space-x-2 rounded-md bg-slate-800 p-2 shadow-sm">
                            <div class="h-4 w-4 rounded-full bg-slate-400" />
                            <div class="h-2 w-[100px] rounded-lg bg-slate-400" />
                        </div>
                        <div class="flex items-center space-x-2 rounded-md bg-slate-800 p-2 shadow-sm">
                            <div class="h-4 w-4 rounded-full bg-slate-400" />
                            <div class="h-2 w-[100px] rounded-lg bg-slate-400" />
                        </div>
                    </div>
                </div>

                <div class="mt-2.5 text-center text-xs capitalize">{{ $t('dark_mode') }}</div>
            </div>
        </div>
    </div>
</template>
