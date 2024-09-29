<script lang="ts" setup>
import type { PopOverPlacementType } from '@/types/types'
import type { ExtractProps } from '@/types/utils'

import { PopoverPanel as HeadlessPopoverPanel, TransitionRoot } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface PanelProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessPopoverPanel> {
    as?: string | object
    placement?: PopOverPlacementType
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div', placement = 'bottom-end' } = defineProps<PanelProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        // eslint-disable-next-line array-element-newline
        'p-2 shadow-[0px_3px_20px_#0000000b] bg-white border-transparent rounded-md dark:bg-darkmode-600 dark:border-transparent',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <transition-root
        as="template"
        enter="transition-all ease-linear duration-150"
        enter-from="mt-5 invisible opacity-0 translate-y-1"
        enter-to="mt-1 visible opacity-100 translate-y-0"
        entered="mt-1"
        leave="transition-all ease-linear duration-150"
        leave-from="mt-1 visible opacity-100 translate-y-0"
        leave-to="mt-5 invisible opacity-0 translate-y-1"
    >
        <div
            :class="[
                'absolute z-30',
                { 'bottom-[100%] start-0': placement == 'top-start' },
                { 'bottom-[100%] start-[50%] translate-x-[-50%]': placement == 'top' },
                { 'bottom-[100%] end-0': placement == 'top-end' },
                { 'start-[100%] translate-y-[-50%]': placement == 'right-start' },
                { 'start-[100%] top-[50%] translate-y-[-50%]': placement == 'right' },
                { 'bottom-0 start-[100%]': placement == 'right-end' },
                { 'end-0 top-[100%]': placement == 'bottom-end' },
                { 'start-[50%] top-[100%] translate-x-[-50%]': placement == 'bottom' },
                { 'start-0 top-[100%]': placement == 'bottom-start' },
                { 'end-[100%] translate-y-[-50%]': placement == 'left-start' },
                { 'end-[100%] top-[50%] translate-y-[-50%]': placement == 'left' },
                { 'bottom-0 end-[100%]': placement == 'left-end' }
            ]"
        >
            <headless-popover-panel v-slot="{ close }" :as="as" :class="computedClass" v-bind="attrs.attrs">
                <slot :close="close"></slot>
            </headless-popover-panel>
        </div>
    </transition-root>
</template>
