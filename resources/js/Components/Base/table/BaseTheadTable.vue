<script setup lang="ts">
import { twMerge } from 'tailwind-merge'
import { type HTMLAttributes, computed, provide } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

export type ProvideThead = {
    variant?: 'default' | 'light' | 'dark'
}

interface TheadProps extends /* @vue-ignore */ HTMLAttributes {
    variant?: 'default' | 'light' | 'dark'
}

defineOptions({
    inheritAttrs: false
})

const { variant = 'default' } = defineProps<TheadProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        variant === 'light' && 'bg-slate-200/60 dark:bg-slate-200',
        variant === 'dark' && 'bg-dark text-white dark:bg-black/30',
        typeof attrs.class === 'string' && attrs.class
    ])
)

provide<ProvideThead>('thead', {
    variant: variant
})
</script>

<template>
    <thead :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </thead>
</template>
