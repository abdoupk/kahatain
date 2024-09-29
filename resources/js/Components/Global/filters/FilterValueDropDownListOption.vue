<script lang="ts" setup>
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    active?: boolean
    selected?: boolean
    label?: string
}>()
</script>

<template>
    <li
        :class="[
            active ? 'bg-primary text-white' : 'text-gray-900 dark:text-slate-300',
            'relative cursor-default select-none py-2 pe-9 ps-3'
        ]"
    >
        <div class="flex items-center">
            <span :class="[selected ? 'font-semibold' : 'font-normal', 'ms-3 block truncate']">{{ label }}</span>
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
</template>
