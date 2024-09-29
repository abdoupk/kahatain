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
        table?.hover && '[&:hover_td]:bg-slate-100 [&:hover_td]:dark:bg-darkmode-300 [&:hover_td]:dark:bg-opacity-50',
        table?.striped &&
            '[&:nth-of-type(odd)_td]:bg-slate-100 [&:nth-of-type(odd)_td]:dark:bg-darkmode-300 [&:nth-of-type(odd)_td]:dark:bg-opacity-50',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <tr :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </tr>
</template>
