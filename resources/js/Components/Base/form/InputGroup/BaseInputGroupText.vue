<script lang="ts" setup>
import type { ProvideInputGroup } from './BaseInputGroup.vue'

import { twMerge } from 'tailwind-merge'
import { computed, inject } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

defineOptions({
    inheritAttrs: false
})

const attrs = useComputedAttrs()

const inputGroup = inject<ProvideInputGroup>('inputGroup')

const computedClass = computed(() =>
    twMerge([
        'py-2 px-3 whitespace-nowrap bg-slate-100 border shadow-sm border-slate-200 text-slate-600 dark:bg-darkmode-900/20 dark:border-darkmode-900/20 dark:text-slate-400',
        inputGroup && 'rounded-none [&:not(:first-child)]:border-s-transparent first:rounded-s last:rounded-e',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <div :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </div>
</template>
