<script setup lang="ts">
import { twMerge } from 'tailwind-merge'
import { type TableHTMLAttributes, computed, provide } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

export type ProvideTable = {
    dark: boolean
    bordered: boolean
    hover: boolean
    striped: boolean
    sm: boolean
}

interface TableProps extends /* @vue-ignore */ TableHTMLAttributes {
    dark?: boolean
    bordered?: boolean
    hover?: boolean
    striped?: boolean
    sm?: boolean
}

defineOptions({
    inheritAttrs: false
})

const { dark = false, bordered = false, hover = false, striped = false, sm = false } = defineProps<TableProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'w-full text-start',
        dark && 'bg-dark text-white dark:bg-black/30',
        typeof attrs.class === 'string' && attrs.class
    ])
)

provide<ProvideTable>('table', {
    dark: dark,
    bordered: bordered,
    hover: hover,
    striped: striped,
    sm: sm
})
</script>

<template>
    <table :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </table>
</template>
