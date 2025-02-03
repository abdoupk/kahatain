<script lang="ts" setup>
import type { ExtractProps } from '@/types/utils'

import { Combobox as HeadlessCombobox } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { useAttrs } from 'vue'

interface ComboboxProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessCombobox> {
    modelValue: unknown
}

const { modelValue } = defineProps<ComboboxProps>()

defineOptions({
    inheritAttrs: false
})

const attrs = useAttrs()

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <headless-combobox :model-value="modelValue" @update:model-value="(value) => emit('update:modelValue', value)">
        <div :class="twMerge(['relative mt-2', attrs.class])">
            <slot></slot>
        </div>
    </headless-combobox>
</template>
