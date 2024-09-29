<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { DialogDescription as HeadlessDialogDescription } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface DescriptionProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDialogDescription> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div' } = defineProps<DescriptionProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() => twMerge(['p-5', typeof attrs.class === 'string' && attrs.class]))
</script>

<template>
    <headless-dialog-description as="template">
        <component :is="as" :class="computedClass" v-bind="attrs.attrs">
            <slot></slot>
        </component>
    </headless-dialog-description>
</template>
