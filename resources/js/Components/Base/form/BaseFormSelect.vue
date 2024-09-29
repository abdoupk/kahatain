<script lang="ts" setup>
import { ProvideFormInline } from './BaseFormInline.vue'

import { twMerge } from 'tailwind-merge'
import { type SelectHTMLAttributes, computed, inject, ref } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface FormSelectProps extends /* @vue-ignore */ SelectHTMLAttributes {
    value?: SelectHTMLAttributes['value']
    modelValue?: SelectHTMLAttributes['value']
    formSelectSize?: 'sm' | 'lg'
}

interface FormSelectEmit {
    (e: 'update:modelValue', value: string): void
}

defineOptions({
    inheritAttrs: false
})

const selectRef = ref<HTMLSelectElement>()

const props = defineProps<FormSelectProps>()

const attrs = useComputedAttrs()

const formInline = inject<ProvideFormInline>('formInline', false)

const computedClass = computed(() =>
    twMerge([
        'disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50',
        '[&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50',
        'transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pe-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50',
        props.formSelectSize == 'sm' && 'text-xs py-1.5 ps-2 pe-8',
        props.formSelectSize == 'lg' && 'text-lg py-1.5 ps-4 pe-8',
        formInline && 'flex-1',
        typeof attrs.class === 'string' && attrs.class
    ])
)

const emit = defineEmits<FormSelectEmit>()

const localValue = computed({
    get() {
        if (props.modelValue === undefined && props.value === undefined) {
            const firstOption = selectRef.value?.querySelectorAll('option')[0]

            return (
                firstOption !== undefined &&
                (firstOption.getAttribute('value') !== null ? firstOption.getAttribute('value') : firstOption.text)
            )
        }

        return props.modelValue === undefined ? props.value : props.modelValue
    },
    set(newValue) {
        emit('update:modelValue', newValue)
    }
})
</script>

<template>
    <select ref="selectRef" v-model="localValue" :class="computedClass" v-bind="$attrs">
        <slot></slot>
    </select>
</template>
