<script lang="ts" setup>
import type { ProvideTable } from './BaseTable.vue'
import type { ProvideThead } from './BaseTheadTable.vue'

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

const thead = inject<ProvideThead>('thead', {
    variant: 'default'
})

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'font-medium px-5 py-3 border-b-2 dark:border-darkmode-300',
        thead?.variant === 'light' && 'border-b-0 text-slate-700',
        thead?.variant === 'dark' && 'border-b-0',
        table?.dark && 'border-slate-600 dark:border-darkmode-300',
        table?.bordered && 'border-l border-r border-t',
        table?.sm && 'px-4 py-2',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <th :class="computedClass" class="flex-col" v-bind="attrs.attrs">
        <slot></slot>
    </th>
</template>
