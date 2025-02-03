<script lang="ts" setup>
import { ComboboxButton as HeadlessComboboxButton, ComboboxInput as HeadlessComboboxInput } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'

import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'
import { useComputedAttrs } from '@/utils/useComputedAttrs'

defineOptions({
    inheritAttrs: false
})

const attrs = useComputedAttrs()

const query = defineModel('query')
</script>

<template>
    <div>
        <headless-combobox-input
            :class="
                twMerge([
                    'w-full rounded-md border-slate-200 text-sm shadow-sm transition duration-200 ease-in-out placeholder:text-slate-400/90 focus:border-primary focus:border-opacity-40 focus:ring-4 focus:ring-primary focus:ring-opacity-20 dark:border-transparent dark:bg-darkmode-800 dark:placeholder:text-slate-500/80 dark:focus:ring-slate-700 dark:focus:ring-opacity-50'
                ])
            "
            :display-value="(option) => (option?.name !== $t('filters.select_an_option') ? option?.name : '')"
            :placeholder="$t('Search...')"
            v-bind="attrs.attrs"
            @change="query = $event.target.value"
        ></headless-combobox-input>

        <headless-combobox-button class="absolute inset-y-0 end-0 flex items-center pe-2">
            <svg-loader aria-hidden="true" class="h-5 w-5 text-gray-400" name="icon-angles-up-down"></svg-loader>
        </headless-combobox-button>
    </div>
</template>
