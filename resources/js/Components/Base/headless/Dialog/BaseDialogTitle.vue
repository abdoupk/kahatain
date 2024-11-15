<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { DialogTitle as HeadlessDialogTitle } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface TitleProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDialogTitle> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div' } = defineProps<TitleProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'flex items-center px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400', typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <headless-dialog-title as="template">
        <component :is="as" :class="computedClass" v-bind="attrs.attrs">
            <slot></slot>
        </component>
    </headless-dialog-title>
</template>
