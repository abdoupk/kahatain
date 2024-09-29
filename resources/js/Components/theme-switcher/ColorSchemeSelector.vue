<script lang="ts" setup>
import type { ColorSchemesType } from '@/types/types'

import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'

import { colorSchemes } from '@/utils/constants'
import { setColorSchemeClass } from '@/utils/helper'

const settingsStore = useSettingsStore()

const switchColorScheme = (colorScheme: ColorSchemesType) => {
    settingsStore.changeColorScheme(colorScheme)

    setColorSchemeClass(colorScheme, settingsStore.appearance)
}
</script>

<template>
    <div class="px-8 pb-8 pt-6">
        <div class="text-base font-medium">{{ $t('theme.accent_color') }}</div>

        <div class="mt-0.5 text-slate-500">{{ $t('theme.accent_color_hint') }}</div>

        <div class="mt-5 grid grid-cols-2 gap-3.5">
            <template v-for="colorScheme in colorSchemes" :key="colorScheme">
                <div>
                    <a
                        :class="
                            twMerge([
                                'box block h-14 cursor-pointer border-slate-300/80 bg-slate-50 p-1',
                                '[&.active]:border-2 [&.active]:border-theme-1/60',
                                colorScheme === settingsStore.colorScheme ? 'active' : ''
                            ])
                        "
                        @click="switchColorScheme(colorScheme)"
                    >
                        <div class="h-full overflow-hidden rounded-md">
                            <div class="-mx-2 flex h-full items-center gap-1">
                                <div :class="twMerge(['h-[200%] w-1/2 rotate-12 bg-theme-1', colorScheme])"></div>
                                <div :class="twMerge(['h-[200%] w-1/2 rotate-12 bg-theme-2', colorScheme])"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </template>
        </div>
    </div>
</template>
