<script lang="ts" setup>
import type { ExtractProps } from '@/types/utils'

import { ComboboxButton, ComboboxOption, ComboboxOptions, Combobox as HeadlessCombobox } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed, ref, useAttrs, watch } from 'vue'

import BaseComboboxInput from '@/Components/Base/headless/Combobox/BaseComboboxInput.vue'
import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

interface ComboboxProps<T> extends /* @vue-ignore */ ExtractProps<typeof HeadlessCombobox> {
    modelValue: T extends true ? unknown[] : unknown
    options: Record<string, unknown>[]
    placeholder?: string
    valueKey?: string
    labelKey?: string
    loadOptions?: () => void
    createOption?: boolean
}

const props = withDefaults(defineProps<ComboboxProps<boolean>>(), {
    placeholder: $t('filters.select_an_option'),
    valueKey: 'value',
    labelKey: 'label'
})

const attrs = useAttrs()

const emit = defineEmits(['update:modelValue'])

const isSelected = (value: unknown) => {
    return value === props.modelValue
}

const handleSelection = (value: unknown) => {
    const newValue = value === props.modelValue ? null : value

    emit('update:modelValue', newValue)
}

const isLoading = ref(false)

let query = ref('')

const queryOption = computed(() => {
    return query.value === ''
        ? null
        : {
              missing: true,
              [props.labelKey]: query.value,
              [props.valueKey]: query.value
          }
})

const options = ref(props.options)

watch(
    query,
    (q) => {
        if (props?.loadOptions && q) {
            isLoading.value = true

            props.loadOptions(q, (results) => {
                options.value = results

                if (
                    props.modelValue &&
                    !options.value?.some((o) => {
                        return o.value === props.modelValue?.value
                    })
                ) {
                    options.value?.unshift(props.modelValue)
                }

                isLoading.value = false
            })
        }
    },
    { immediate: true }
)

let filteredOptions = computed(() =>
    query.value === ''
        ? options.value
        : options.value?.filter((option) =>
              option[props.labelKey]
                  ?.toLowerCase()
                  .replace(/\s+/g, '')
                  .includes(query.value?.toLowerCase().replace(/\s+/g, ''))
          )
)

const handleDisplayValue = (option) => {
    if (option?.missing) {
        return option[props.labelKey]
    } else if (option) {
        const foundOption = filteredOptions.value?.find((o) => option === o[props.valueKey])

        return foundOption ? foundOption[props.labelKey] || '' : ''
    }

    return ''
}
</script>

<template>
    <headless-combobox :model-value="modelValue" @update:model-value="handleSelection">
        <div :class="twMerge(['relative mt-2', attrs.class])">
            <base-combobox-input
                :displayValue="handleDisplayValue"
                v-bind="attrs.attrs"
                :placeholder
                @change="query = $event.target.value"
            ></base-combobox-input>

            <combobox-button class="absolute inset-y-0 end-0 flex items-center pe-2">
                <svg-loader aria-hidden="true" class="h-5 w-5 text-gray-400" name="icon-angles-up-down"></svg-loader>
            </combobox-button>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <combobox-options
                    :class="{ 'py-1': filteredOptions?.length && createOption > 0 }"
                    class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-darkmode-800 sm:text-sm"
                >
                    <div
                        v-if="isLoading"
                        class="flex cursor-default select-none items-center justify-center px-4 py-2 text-gray-700"
                    >
                        <spinner-loader class="h-4 w-4"></spinner-loader>
                    </div>

                    <template v-if="!isLoading">
                        <combobox-option
                            v-if="queryOption && createOption && !filteredOptions?.length"
                            v-slot="{ active }"
                            :value="queryOption"
                            as="div"
                        >
                            <li
                                :class="{
                                    'bg-primary': active
                                }"
                                class="relative cursor-default select-none py-2 pe-4 ps-10 text-white"
                            >
                                {{ $t('create') }} "{{ queryOption[labelKey] }}"
                            </li>
                        </combobox-option>

                        <combobox-option
                            v-for="option in filteredOptions"
                            :key="option[valueKey]"
                            v-slot="{ selected, active }"
                            :value="option[valueKey]"
                            as="div"
                        >
                            <li
                                v-if="option[valueKey]"
                                :class="[
                                    active ? 'bg-primary text-white' : 'text-gray-900 dark:text-slate-300',
                                    'relative cursor-default select-none py-2 pe-9 ps-3'
                                ]"
                            >
                                <div class="flex items-center">
                                    <span
                                        :class="[
                                            selected ? 'font-semibold' : 'font-normal',
                                            'ms-3 block truncate text-sm'
                                        ]"
                                    >
                                        {{ option[labelKey] }}
                                    </span>
                                </div>

                                <span
                                    v-if="isSelected(option[valueKey])"
                                    :class="[
                                        active ? 'text-white' : 'text-primary',
                                        'absolute inset-y-0 end-0 flex items-center pe-4'
                                    ]"
                                >
                                    <svg-loader
                                        :class="[
                                            active || isSelected(option[valueKey]) ? 'fill-white' : 'fill-primary'
                                        ]"
                                        aria-hidden="true"
                                        class="h-5 w-5"
                                        name="icon-check"
                                    ></svg-loader>
                                </span>
                            </li>
                        </combobox-option>
                    </template>
                </combobox-options>
            </transition>
        </div>
    </headless-combobox>
</template>
