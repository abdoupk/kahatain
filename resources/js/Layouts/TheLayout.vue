<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import type { PageProps } from '@/types'
import { usePage } from '@inertiajs/vue3'
import { defineAsyncComponent, onMounted } from 'vue'

import TheLayoutLoader from '@/Components/Global/TheLayoutLoader.vue'

import { setColorSchemeClass, setDarkModeClass, setFontSizeClass } from '@/utils/helper'

const EnigmaTheme = defineAsyncComponent(() => import('@/Layouts/enigma/EnigmaTheme.vue'))

const IcewallTheme = defineAsyncComponent(() => import('@/Layouts/icewall/IcewallTheme.vue'))

const RubickTheme = defineAsyncComponent(() => import('@/Layouts/rubick/RubickTheme.vue'))

const TinkerTheme = defineAsyncComponent(() => import('@/Layouts/tinker/TinkerTheme.vue'))

const settingsStore = useSettingsStore()

onMounted(() => {
    settingsStore.layout = usePage<PageProps>().props.auth.settings.layout

    settingsStore.theme = usePage<PageProps>().props.auth.settings.theme

    settingsStore.colorScheme = usePage<PageProps>().props.auth.settings.color_scheme

    settingsStore.appearance = usePage<PageProps>().props.auth.settings.appearance

    settingsStore.fontSize = usePage<PageProps>().props.auth.settings.font_size

    setDarkModeClass(settingsStore.appearance)

    setColorSchemeClass(settingsStore.colorScheme, settingsStore.appearance)

    setFontSizeClass(settingsStore.fontSize)
})
</script>

<template>
    <suspense>
        <div>
            <suspense v-if="settingsStore.theme === 'enigma'" suspensible>
                <enigma-theme>
                    <slot></slot>
                </enigma-theme>

                <template #fallback>
                    <the-layout-loader></the-layout-loader>
                </template>
            </suspense>

            <icewall-theme v-if="settingsStore.theme === 'icewall'">
                <slot></slot>
            </icewall-theme>

            <rubick-theme v-if="settingsStore.theme === 'rubick'">
                <slot></slot>
            </rubick-theme>

            <tinker-theme v-if="settingsStore.theme === 'tinker'">
                <slot></slot>
            </tinker-theme>
        </div>

        <template #fallback>
            <the-layout-loader></the-layout-loader>
        </template>
    </suspense>
</template>
