<script setup lang="ts">
import { twMerge } from 'tailwind-merge'
import { type InputHTMLAttributes, computed } from 'vue'

import BaseFormCheckInput from '@/Components/Base/form/form-check/BaseFormCheckInput.vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface InputProps extends /* @vue-ignore */ InputHTMLAttributes {
    modelValue?: InputHTMLAttributes['value']
    type: 'checkbox'
}

interface InputEmit {
    (e: 'update:modelValue', value: string): void
}

defineOptions({
    inheritAttrs: false
})

const props = defineProps<InputProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        // Default
        'w-[38px] h-[24px] p-px rounded-full relative',
        'before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] ltr:before:transition-[margin-left] rtl:before:transition-[margin-right] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600',

        // On checked
        'checked:bg-primary checked:border-primary checked:bg-none',
        'before:checked:ms-[14px] before:checked:bg-white',

        typeof attrs.class === 'string' && attrs.class
    ])
)

const emit = defineEmits<InputEmit>()

const localValue = computed({
    get() {
        return props.modelValue
    },
    set(newValue) {
        emit('update:modelValue', newValue)
    }
})
</script>

<template>
    <base-form-check-input :type="props.type" :class="computedClass" v-bind="$attrs" v-model="localValue" />
</template>
