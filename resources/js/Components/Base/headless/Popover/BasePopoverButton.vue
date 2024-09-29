<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { PopoverButton as HeadlessPopoverButton } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface ButtonProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessPopoverButton> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div' } = defineProps<ButtonProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() => twMerge(['cursor-pointer', typeof attrs.class === 'string' && attrs.class]))
</script>

<template>
    <headless-popover-button as="template">
        <component :is="as" :class="computedClass" v-bind="attrs.attrs"> <slot></slot></component>
    </headless-popover-button>
</template>
