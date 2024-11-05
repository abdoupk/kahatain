<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'

import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'

import { $t } from '@/utils/i18n'

const settingsStore = useSettingsStore()

const theFontSize = defineModel('theFontSize')

theFontSize.value = settingsStore.fontSize
</script>

<template>
    <div class="mt-5">
        <div class="rtl:text-lg rtl:font-semibold">{{ $t('theme.font_size') }}</div>

        <div class="mt-0.5 text-slate-500">{{ $t('theme.font_size_hint') }}</div>

        <div class="mt-5 grid grid-cols-2 gap-3.5">
            <base-form-select v-model="theFontSize" @update:model-value="settingsStore.changeFontSize($event)">
                <option value="font_size_xs">
                    {{ $t('theme.font_size_xs') }}
                </option>

                <option value="font_size_sm">
                    {{ $t('theme.font_size_sm') }}
                </option>

                <option value="font_size_base">
                    {{ $t('theme.font_size_base') }}
                </option>

                <option value="font_size_lg">
                    {{ $t('theme.font_size_lg') }}
                </option>

                <option value="font_size_xl">
                    {{ $t('theme.font_size_xl') }}
                </option>
            </base-form-select>
        </div>
    </div>
</template>
