<script setup lang="ts">
import type { ProvideSlideover } from './BaseSlideover.vue'

import type { ExtractProps } from '@/types/utils'

import { DialogPanel as HeadlessDialogPanel, TransitionChild } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed, inject } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface PanelProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDialogPanel> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div' } = defineProps<PanelProps>()

const slideover = inject<ProvideSlideover>('slideover')

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'w-[90%] ms-auto h-screen flex flex-col bg-white relative shadow-md transition-transform dark:bg-darkmode-600',
        slideover?.size == 'md' && 'sm:w-[460px]',
        slideover?.size == 'sm' && 'sm:w-[300px]',
        slideover?.size == 'lg' && 'sm:w-[600px]',
        slideover?.size == 'xl' && 'sm:w-[600px] lg:w-[900px]',
        slideover?.zoom.value && 'scale-105',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <transition-child
        as="div"
        enter="ease-in-out duration-500"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in-out duration-[400ms]"
        leave-from="opacity-100"
        leave-to="opacity-0"
        class="fixed inset-0 bg-black/60"
        aria-hidden="true"
    />
    <transition-child
        as="div"
        enter="ease-in-out duration-500"
        enter-from="opacity-0 -me-[100%]"
        enter-to="opacity-100 me-0"
        leave="ease-in-out duration-[400ms]"
        leave-from="opacity-100 me-0"
        leave-to="opacity-0 -me-[100%]"
        class="fixed inset-y-0 end-0"
    >
        <headless-dialog-panel as="template">
            <component :is="as" :class="computedClass" v-bind="attrs.attrs">
                <slot></slot>
            </component>
        </headless-dialog-panel>
    </transition-child>
</template>
