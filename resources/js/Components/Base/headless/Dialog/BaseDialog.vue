<script lang="ts" setup>
import type { ExtractProps } from '@/types/utils'

import { Dialog as HeadlessDialog, TransitionRoot } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { type Ref, computed, provide, ref, useAttrs } from 'vue'

import { omit } from '@/utils/helper'

type Size = 'sm' | 'md' | 'lg' | 'xl'

export type ProvideDialog = {
    open: boolean
    zoom: Ref<boolean>
    size?: Size
}

interface DialogProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDialog> {
    size?: Size
    open: boolean
    staticBackdrop?: boolean
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div', onClose, open = false, staticBackdrop, size = 'md' } = defineProps<DialogProps>()

const computedOpen = computed(() => open)

const attrs = useAttrs()

const computedClass = computed(() => twMerge(['relative z-[60]', typeof attrs.class === 'string' && attrs.class]))

const zoom = ref(false)

const emit = defineEmits<{
    (e: 'close', value: boolean): void
}>()

const handleClose = (value: boolean) => {
    if (!staticBackdrop) {
        onClose && onClose(value)

        emit('close', value)
    } else {
        zoom.value = true

        setTimeout(() => {
            zoom.value = false
        }, 300)
    }
}

provide<ProvideDialog>('dialog', {
    open: computedOpen.value,
    zoom: zoom,
    size: size
})
</script>

<template>
    <transition-root :show="open" appear as="template">
        <headless-dialog
            :as
            :class="computedClass"
            class="dialog"
            v-bind="omit(attrs, ['onClose'])"
            @close="
                (value) => {
                    handleClose(value)
                }
            "
        >
            <slot></slot>
        </headless-dialog>
    </transition-root>
</template>

<style>
.dialog *:focus {
    outline: none !important;
}
</style>
