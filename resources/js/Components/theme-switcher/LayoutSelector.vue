<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { twMerge } from 'tailwind-merge'

import { layouts } from '@/utils/constants'

const settingsStore = useSettingsStore()
</script>

<template>
    <div class="px-8 pb-8 pt-6">
        <div class="text-base font-medium">{{ $t('theme.layouts') }}</div>

        <div class="mt-0.5 text-slate-500">{{ $t('theme.layouts_hint') }}</div>

        <div class="mt-5 grid grid-cols-3 gap-x-5 gap-y-3.5">
            <template v-for="layout in layouts" :key="layout">
                <div>
                    <a
                        :class="
                            twMerge([
                                'box block h-24 cursor-pointer bg-slate-50 p-1',
                                settingsStore?.layout === layout
                                    ? 'border-2 border-theme-1/60 dark:border-darkmode-50'
                                    : ''
                            ])
                        "
                        @click.prevent="settingsStore.changeLayout(layout)"
                    >
                        <div class="image-fit h-full w-full overflow-hidden rounded-md">
                            <img
                                :alt="layout"
                                :src="`/images/layouts/${layout.replace('_', '-')}.png`"
                                class="h-full w-full"
                            />
                        </div>
                    </a>
                    <div class="mt-2.5 text-center text-xs capitalize">
                        {{ layout.replace('_', '-') }}
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
