<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { MenuButton as HeadlessMenuButton } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface ButtonProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessMenuButton> {
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
    <headless-menu-button as="template">
        <component :is="as" :class="computedClass" v-bind="attrs.attrs">
            <slot></slot>
        </component>
    </headless-menu-button>
</template>
