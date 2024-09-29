<script setup lang="ts">
import type { ProvideTable } from './BaseTable.vue'

import { twMerge } from 'tailwind-merge'
import { computed, inject } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

defineOptions({
    inheritAttrs: false
})

const table = inject<ProvideTable>('table', {
    dark: false,
    bordered: false,
    hover: false,
    striped: false,
    sm: false
})

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'px-5 py-3 border-b dark:border-darkmode-300',
        table?.dark && 'border-slate-600 dark:border-darkmode-300',
        table?.bordered && 'border-l border-r border-t',
        table?.sm && 'px-4 py-2',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <td :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </td>
</template>
