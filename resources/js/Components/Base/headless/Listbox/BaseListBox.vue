<script lang="ts" setup>
import { Listbox, ListboxButton, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

type Props<T> = {
    modelValue: T extends true ? unknown[] : unknown
    options: Record<string, unknown>[]
    multiple?: T
    placeholder?: string
    buttonClass?: string
    optionsClass?: string
    optionClass?: (active: boolean, selected: boolean) => string
    valueKey?: string
    labelKey?: string
    groupLabel?: string
    groupValues?: string
}

const props = withDefaults(defineProps<Props<boolean>>(), {
    multiple: false,
    placeholder: $t('filters.select_an_option'),
    buttonClass: '',
    optionsClass: '',
    optionClass: undefined,
    valueKey: 'value',
    labelKey: 'label',
    groupLabel: '',
    groupValues: ''
})

const emit = defineEmits<{
    (e: 'update:modelValue', value: unknown | unknown[]): void
}>()

const arrayValue = computed(() => {
    return props.multiple
        ? (props.modelValue as unknown[])
        : props.modelValue !== null && props.modelValue !== undefined
          ? [props.modelValue]
          : []
})

const displayValue = computed(() => {
    if (props.multiple) {
        return arrayValue.value.length > 0 ? `${arrayValue.value.length} selected` : ''
    } else {
        if (props.modelValue === null || props.modelValue === undefined) {
            return ''
        }

        const flattenedOptions =
            props.groupLabel && props.groupValues
                ? props.options.flatMap((option) => option[props.groupValues] || [])
                : props.options

        const selectedOption = flattenedOptions.find((o) => o[props.valueKey] === props.modelValue)

        return selectedOption?.[props.labelKey]
    }
})

const isSelected = (value: unknown) => {
    return props.multiple ? arrayValue.value.includes(value) : value === props.modelValue
}

const handleSelection = (value: unknown) => {
    if (props.multiple) {
        emit('update:modelValue', value as unknown[])
    } else {
        const newValue = value === props.modelValue ? null : value

        emit('update:modelValue', newValue)
    }
}

const deselectValue = (value: unknown) => {
    if (props.multiple) {
        const newValues = arrayValue.value?.filter((v) => v !== value)

        emit('update:modelValue', newValues)
    }
}

const getLabel = (value: unknown) => {
    return props.options.find((o) => o[props.valueKey] === value)?.[props.labelKey] || String(value)
}

// Group options by groupLabel and groupValues
const groupedOptions = computed(() => {
    if (!props.groupLabel || !props.groupValues) return props.options // No grouping

    const groups: Record<string, unknown[]> = {}

    props.options.forEach((option) => {
        const groupKey = option[props.groupLabel] || 'Ungrouped'

        if (!groups[groupKey]) {
            groups[groupKey] = []
        }

        // Add nested values under groupValues
        if (option[props.groupValues] && Array.isArray(option[props.groupValues])) {
            groups[groupKey].push(...option[props.groupValues])
        } else {
            groups[groupKey].push(option)
        }
    })

    return groups
})
</script>

<template>
    <Listbox :model-value="modelValue" :multiple="multiple" @update:model-value="handleSelection">
        <div class="relative">
            <ListboxButton
                :class="
                    twMerge([
                        'w-full rounded-md border border-slate-200 px-4 py-2 text-sm shadow-sm transition duration-200 ease-in-out placeholder:text-slate-400/90 focus:border-primary focus:border-opacity-40 focus:ring-4 focus:ring-primary focus:ring-opacity-20 dark:border-transparent dark:bg-darkmode-800 dark:placeholder:text-slate-500/80 dark:focus:ring-slate-700 dark:focus:ring-opacity-50',
                        buttonClass
                    ])
                "
            >
                <div class="flex flex-wrap items-center gap-1">
                    <template v-if="multiple">
                        <span
                            v-for="value in arrayValue"
                            :key="value"
                            class="flex items-center gap-1 rounded-full px-2 py-1 text-sm hover:bg-primary/60"
                        >
                            {{ getLabel(value) }}
                            <button
                                v-if="multiple"
                                aria-label="Deselect"
                                class="hover:text-primary"
                                @click.stop="deselectValue(value)"
                            >
                                <svg-loader class="h-4 w-4" name="icon-x-mark"></svg-loader>
                            </button>
                        </span>
                        <span v-if="arrayValue.length === 0" class="text-slate-400/90 dark:text-slate-500/80">
                            {{ placeholder }}
                        </span>
                    </template>

                    <template v-else>
                        <span
                            :class="{
                                'text-slate-400/90 dark:text-slate-500/80': !displayValue
                            }"
                        >
                            {{ displayValue || placeholder }}
                        </span>
                    </template>
                </div>

                <span class="pointer-events-none absolute inset-y-0 end-0 ms-3 flex items-center pe-2">
                    <svg-loader
                        aria-hidden="true"
                        class="h-5 w-5 text-gray-400"
                        name="icon-angles-up-down"
                    ></svg-loader>
                </span>
            </ListboxButton>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    :class="{ 'py-1': options.length > 0, optionsClass }"
                    class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-darkmode-800 sm:text-sm"
                >
                    <template v-if="groupLabel && groupValues">
                        <!-- Render grouped options -->
                        <div v-for="(group, groupName) in groupedOptions" :key="groupName">
                            <div class="px-3 py-2 text-sm font-semibold text-gray-500 dark:text-slate-400">
                                {{ groupName }}
                            </div>
                            <ListboxOption
                                v-for="option in group"
                                :key="option[valueKey]"
                                v-slot="{ active, selected }"
                                :disabled="option.disabled"
                                :value="option[valueKey]"
                            >
                                <li
                                    :class="[
                                        active ? 'bg-primary text-white' : 'text-gray-900 dark:text-slate-300',
                                        'relative cursor-default select-none py-2 pe-9 ps-3',
                                        optionClass ? optionClass(active, selected) : ''
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
                            </ListboxOption>
                        </div>
                    </template>

                    <template v-else>
                        <!-- Render ungrouped options -->
                        <ListboxOption
                            v-for="option in options"
                            :key="option[valueKey]"
                            v-slot="{ active, selected }"
                            :disabled="option.disabled"
                            :value="option[valueKey]"
                        >
                            <li
                                :class="[
                                    active ? 'bg-primary text-white' : 'text-gray-900 dark:text-slate-300',
                                    'relative cursor-default select-none py-2 pe-9 ps-3',
                                    optionClass ? optionClass(active, selected) : ''
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
                        </ListboxOption>
                    </template>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
