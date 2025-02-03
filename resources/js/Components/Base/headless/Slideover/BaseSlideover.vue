<script lang="ts" setup>
import type { ExtractProps } from '@/types/utils'

import { Dialog as HeadlessDialog, TransitionRoot } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { type Ref, computed, provide, ref } from 'vue'

import { omit } from '@/utils/helper'
import { useComputedAttrs } from '@/utils/useComputedAttrs'

type Size = 'sm' | 'md' | 'lg' | 'xl'

export type ProvideSlideover = {
    open: boolean
    zoom: Ref<boolean>
    size?: Size
}

interface SlideoverProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDialog> {
    size?: Size
    open: boolean
    staticBackdrop?: boolean
}

const props = withDefaults(defineProps<SlideoverProps>(), {
    as: 'div',
    open: false,
    size: 'md'
})

const { as, onClose, staticBackdrop, size } = props

const open = computed(() => props.open)

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    // eslint-disable-next-line array-element-newline
    twMerge(['relative z-[60]', typeof attrs.class === 'string' && attrs.class])
)

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

provide<ProvideSlideover>('slideover', {
    open: open.value,
    zoom: zoom,
    size: size
})
</script>

<template>
    <transition-root :show="open" appear as="template">
        <headless-dialog
            :as
            :class="computedClass"
            class="dialog pb-safe-bottom"
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
