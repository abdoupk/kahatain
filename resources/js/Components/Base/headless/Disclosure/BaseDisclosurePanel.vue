<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { DisclosurePanel as HeadlessDisclosurePanel, TransitionRoot } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface PanelProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDisclosurePanel> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as } = withDefaults(defineProps<PanelProps>(), {
    as: 'div'
})

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge(['mt-3 text-slate-700 leading-relaxed dark:text-slate-400', typeof attrs.class === 'string' && attrs.class])
)
</script>

<template>
    <transition-root
        as="template"
        enter="overflow-hidden transition-all linear duration-[400ms]"
        enter-from="mt-0 max-h-0 invisible opacity-0"
        enter-to="mt-3 max-h-[2000px] visible opacity-100"
        entered="mt-3"
        leave="overflow-hidden transition-all linear duration-500"
        leave-from="mt-3 max-h-[2000px] visible opacity-100"
        leave-to="mt-0 max-h-0 invisible opacity-0"
    >
        <headless-disclosure-panel as="template">
            <component :is="as" :class="computedClass" v-bind="attrs.attrs">
                <slot></slot>
            </component>
        </headless-disclosure-panel>
    </transition-root>
</template>
