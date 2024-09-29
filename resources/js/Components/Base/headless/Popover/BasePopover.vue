<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { Popover as HeadlessPopover } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface PopoverProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessPopover> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div' } = defineProps<PopoverProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() => twMerge(['relative', typeof attrs.class === 'string' && attrs.class]))
</script>

<template>
    <HeadlessPopover as="template" v-slot="{ close }">
        <component :is="as" :class="computedClass" v-bind="attrs.attrs">
            <slot :close="close"></slot>
        </component>
    </HeadlessPopover>
</template>
