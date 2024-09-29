<script setup lang="ts">
import { twMerge } from 'tailwind-merge'
import { type ButtonHTMLAttributes, computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface DismissButtonProps extends /* @vue-ignore */ ButtonHTMLAttributes {
    as?: string | object
}

const { as = 'button' } = defineProps<DismissButtonProps>()

defineOptions({
    inheritAttrs: false
})

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge(['text-slate-800 py-2 px-3 absolute end-0 my-auto me-2', typeof attrs.class === 'string' && attrs.class])
)
</script>

<template>
    <component :is="as" type="button" aria-label="Close" :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </component>
</template>
