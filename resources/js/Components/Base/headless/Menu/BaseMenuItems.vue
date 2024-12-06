<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { MenuItems as HeadlessMenuItems, TransitionRoot } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface ItemsProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessMenuItems> {
    as?: string | object
    placement?:
        | 'top-start'
        | 'top'
        | 'top-end'
        | 'right-start'
        | 'right'
        | 'right-end'
        | 'bottom-end'
        | 'bottom'
        | 'bottom-start'
        | 'left-start'
        | 'left'
        | 'left-end'
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div', placement = 'bottom-end' } = defineProps<ItemsProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'p-2 shadow-[0px_3px_10px_#00000017] bg-white border-transparent rounded-md dark:bg-darkmode-600 dark:border-transparent',
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
            <headless-menu-items as="template">
                <component :is="as" :class="computedClass" v-bind="attrs.attrs">
                    <slot></slot>
                </component>
            </headless-menu-items>
        </div>
    </transition-root>
</template>
