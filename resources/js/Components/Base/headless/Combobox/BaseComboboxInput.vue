<script lang="ts" setup>
import { ComboboxInput } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'

import { $t } from '@/utils/i18n'
import { useComputedAttrs } from '@/utils/useComputedAttrs'

const attrs = useComputedAttrs()

defineProps<{
    placeholder?: string
}>()
</script>

<template>
    <combobox-input
        :class="
            twMerge([
                'w-full rounded-md border-slate-200 text-sm shadow-sm transition duration-200 ease-in-out placeholder:text-slate-400/90 focus:border-primary focus:border-opacity-40 focus:ring-4 focus:ring-primary focus:ring-opacity-20 dark:border-transparent dark:bg-darkmode-800 dark:placeholder:text-slate-500/80 dark:focus:ring-slate-700 dark:focus:ring-opacity-50',
                attrs.class
            ])
        "
        v-bind="attrs.attrs"
        :placeholder="placeholder ? $t(placeholder) : $t('Search...')"
    ></combobox-input>
</template>
