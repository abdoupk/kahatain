<script lang="ts" setup>
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

defineOptions({
    inheritAttrs: false
})

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge(['cursor-pointer ms-2 rtl:font-semibold', typeof attrs.class === 'string' && attrs.class])
)
</script>

<template>
    <label :class="computedClass" v-bind="attrs.attrs">
        <slot></slot>
    </label>
</template>
