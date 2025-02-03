<script lang="ts" setup>
import { ComboboxOption as HeadlessComboboxOption } from '@headlessui/vue'

import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    options: {
        id: string
        name: string
    }[]
}>()
</script>

<template>
    <headless-combobox-option
        v-for="option in options"
        :key="option.id"
        v-slot="{ selected, active }"
        :value="option"
        as="template"
    >
        <li
            :class="[
                active ? 'bg-primary text-white' : 'text-gray-900 dark:text-slate-300',
                'relative cursor-default select-none py-2 pe-9 ps-3'
            ]"
        >
            <div class="flex items-center">
                <span :class="[selected ? 'font-semibold' : 'font-normal', 'ms-3 block truncate text-sm']">
                    {{ option.name }}
                </span>
            </div>

            <span
                v-if="selected"
                :class="[active ? 'text-white' : 'text-primary', 'absolute inset-y-0 end-0 flex items-center pe-4']"
            >
                <svg-loader
                    :class="[active ? 'fill-white' : 'fill-primary']"
                    aria-hidden="true"
                    class="h-5 w-5"
                    name="icon-check"
                ></svg-loader>
            </span>
        </li>
    </headless-combobox-option>
</template>
