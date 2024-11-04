<script lang="ts" setup>
import type { AppearanceType, ColorSchemesType, FontSizeType, LayoutsType, ThemesType } from '@/types/types'

import { useSettingsStore } from '@/stores/settings'
import { useForm } from 'laravel-precognition-vue'

import TheAccentColorSelector from '@/Pages/Profile/appearance/TheAccentColorSelector.vue'
import TheAppearanceSelector from '@/Pages/Profile/appearance/TheAppearanceSelector.vue'
import TheFontSizeSelector from '@/Pages/Profile/appearance/TheFontSizeSelector.vue'
import TheLayoutSelector from '@/Pages/Profile/appearance/theLayoutSelector.vue'
import TheThemeSelector from '@/Pages/Profile/appearance/theThemeSelector.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

import { setColorSchemeClass, setDarkModeClass, setFontSizeClass } from '@/utils/helper'

const form = useForm<{
    appearance: AppearanceType
    layout: LayoutsType
    theme: ThemesType
    color_scheme: ColorSchemesType
    font_size: FontSizeType
}>('put', route('tenant.profile.settings.update'), {
    appearance: useSettingsStore().appearance,
    layout: useSettingsStore().layout,
    theme: useSettingsStore().theme,
    color_scheme: useSettingsStore().colorScheme,
    font_size: useSettingsStore().fontSize
})

const submit = () => {
    form.submit({
        onSuccess: () => {
            useSettingsStore().theme = form.theme

            useSettingsStore().layout = form.layout

            setDarkModeClass(form.appearance)

            setColorSchemeClass(form.color_scheme, form.appearance)

            setFontSizeClass(form.font_size)
        }
    })
}
</script>

<template>
    <div class="border-b pb-5 pe-5">
        <h2 class="rtl:text-xl rtl:font-semibold">{{ $t('appearance') }}</h2>

        <p class="mt-1 text-slate-600 dark:text-slate-400">
            {{ $t('theme.profile_appearance_hint') }}
        </p>
    </div>

    <form @submit.prevent="submit">
        <div class="py-5 pe-5">
            <the-theme-selector v-model:the-theme="form.theme"></the-theme-selector>

            <the-layout-selector v-model:the-layout="form.layout"></the-layout-selector>

            <the-appearance-selector v-model:appearance="form.appearance"></the-appearance-selector>

            <the-accent-color-selector v-model:the-accent-color="form.color_scheme"></the-accent-color-selector>

            <the-font-size-selector v-model:the-font-size="form.font_size"></the-font-size-selector>

            <div class="col-span-12 mt-2 flex justify-end">
                <base-button :disabled="form.processing" class="w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </div>
    </form>
</template>
