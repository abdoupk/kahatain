<script lang="ts" setup>
import { Combobox, ComboboxButton, ComboboxInput, ComboboxOption, ComboboxOptions } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed, ref, watch } from 'vue'

import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'
import FilterValueDropDownListOption from '@/Components/Global/filters/FilterValueDropDownListOption.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

const emit = defineEmits(['update:modelValue'])

const props = defineProps<{
    modelValue: object
    hasError: boolean
    maxLength: number
    options: {
        type: Array
        default: () => []
    }
    loadOptions: () => void
    createOption?: () => void
    size?: 'sm' | 'md'
}>()

const options = ref(props.options)

const isLoading = ref(false)

const queryOption = computed(() => {
    return query.value === ''
        ? null
        : {
              missing: true,
              label: query.value
          }
})

let query = ref('')

watch(
    query,
    (q) => {
        if (props.loadOptions) {
            isLoading.value = true

            props.loadOptions(q, (results) => {
                options.value = results

                if (
                    props.modelValue &&
                    !options.value.some((o) => {
                        return o.value === props.modelValue?.value
                    })
                ) {
                    options.value.unshift(props.modelValue)
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
        : options.value.filter((option) =>
              option.name?.toLowerCase().replace(/\s+/g, '').includes(query.value?.toLowerCase().replace(/\s+/g, ''))
          )
)

function handleUpdateModelValue(selected) {
    emit('update:modelValue', selected)
}

const queryPerson = computed(() => {
    return query.value === '' ? null : { id: null, name: query.value }
})
</script>

<template>
    <combobox :model-value="props.modelValue" by="name" @update:model-value="handleUpdateModelValue">
        <div class="relative mt-2">
            <div>
                <combobox-input
                    :class="
                        twMerge([
                            'w-full rounded-md border-slate-200 text-sm shadow-sm transition duration-200 ease-in-out placeholder:text-slate-400/90 focus:border-primary focus:border-opacity-40 focus:ring-4 focus:ring-primary focus:ring-opacity-20 dark:border-transparent dark:bg-darkmode-800 dark:placeholder:text-slate-500/80 dark:focus:ring-slate-700 dark:focus:ring-opacity-50',
                            size === 'sm' && 'py-1.5 pe-8 ps-2 text-xs',
                            hasError && '!border-red-500 focus:border-danger focus:ring-danger'
                        ])
                    "
                    :displayValue="(option) => (option?.name !== $t('filters.select_an_option') ? option?.name : '')"
                    :maxlength="maxLength"
                    :placeholder="$t('Search...')"
                    @change="query = $event.target.value"
                />

                <combobox-button class="absolute inset-y-0 end-0 flex items-center pe-2">
                    <svg-loader
                        aria-hidden="true"
                        class="h-5 w-5 text-gray-400"
                        name="icon-angles-up-down"
                    ></svg-loader>
                </combobox-button>
            </div>

            <transition
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <combobox-options
                    :class="{ 'py-1': filteredOptions?.length > 0 }"
                    class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-darkmode-800 sm:text-sm"
                >
                    <div
                        v-if="filteredOptions?.length === 0 && !isLoading && !queryOption && !props.createOption"
                        class="relative cursor-default select-none px-4 py-2 text-gray-700"
                    >
                        {{ $t('No results found.') }}
                    </div>

                    <div
                        v-if="isLoading"
                        class="flex cursor-default select-none items-center justify-center px-4 py-2 text-gray-700"
                    >
                        <spinner-loader class="h-4 w-4"></spinner-loader>
                    </div>

                    <template v-if="!isLoading">
                        <combobox-option v-if="queryPerson" v-slot="{ selected, active }" :value="queryPerson">
                            <filter-value-drop-down-list-option
                                :active
                                :label="queryPerson.name"
                                :selected
                            ></filter-value-drop-down-list-option>
                        </combobox-option>

                        <combobox-option
                            v-for="option in filteredOptions"
                            :key="option.id"
                            v-slot="{ selected, active }"
                            :value="option"
                            as="template"
                        >
                            <filter-value-drop-down-list-option
                                :active
                                :label="option.name"
                                :selected
                            ></filter-value-drop-down-list-option>
                        </combobox-option>
                    </template>
                </combobox-options>
            </transition>
        </div>
    </combobox>
</template>
