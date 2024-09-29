<script setup lang="ts">
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

defineOptions({
    inheritAttrs: false
})

const attrs = useComputedAttrs()

const computedClass = computed(() => twMerge(['cursor-pointer ms-2', typeof attrs.class === 'string' && attrs.class]))
</script>

<template>
    <label :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </label>
</template>
