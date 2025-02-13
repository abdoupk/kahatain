<script lang="ts" setup>
import { ComboboxOptions as HeadlessComboboxOptions } from '@headlessui/vue'

defineProps<{
    options: Array
}>()
</script>

<template>
    <transition
        leave-active-class="transition ease-in duration-100"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <headless-combobox-options
            :class="{ 'py-1': options?.length > 0 }"
            class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-darkmode-800 sm:text-sm"
        >
            <slot></slot>
        </headless-combobox-options>
    </transition>
</template>
