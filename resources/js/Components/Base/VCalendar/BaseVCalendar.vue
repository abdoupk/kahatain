<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { DatePicker } from 'v-calendar'
import 'v-calendar/style.css'
import { ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { getLocale } from '@/utils/i18n'

const settingsStore = useSettingsStore()

const date = defineModel('date')

const masks = ref({
    input: 'DD/MM/YYYY'
})

const popover = ref({
    visibility: 'focus',
    placement: getLocale() === 'ar' ? 'top-end' : 'top-start'
})
</script>

<template>
    <date-picker
        v-model="date"
        :is-dark="settingsStore.appearance === 'dark'"
        :locale="getLocale()"
        :masks="masks"
        :popover
        borderless
        color="primary"
        mode="date"
        title-position="left"
        transparent
    >
        <template v-slot="{ togglePopover, inputValue, inputEvents }">
            <div class="relative">
                <div
                    class="absolute flex h-full w-10 items-center justify-center rounded-s border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400"
                    @click="
                        () => {
                            if (!$attrs.disabled) {
                                togglePopover()
                            }
                        }
                    "
                >
                    <svg-loader
                        v-if="$attrs?.mode === 'time'"
                        class="h-4 w-4 fill-current"
                        name="icon-clock"
                    ></svg-loader>

                    <svg-loader v-else class="h-4 w-4 fill-current" name="icon-calendar"></svg-loader>
                </div>

                <base-form-input
                    :disabled="$attrs.disabled"
                    :placeholder="
                        $attrs?.placeholder || $t('auth.placeholders.tomselect', { attribute: $t('the date') })
                    "
                    :value="inputValue"
                    class="ps-12"
                    v-on="inputEvents"
                ></base-form-input>
            </div>
        </template>
    </date-picker>
</template>

<style lang="postcss">
@import '/resources/css/vendors/v-calendar.css';
</style>
