<script setup>
import { computed, ref, watch } from 'vue'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'
import BaseComboboxInput from '@/Components/Base/headless/Combobox/BaseComboboxInput.vue'
import BaseComboboxOption from '@/Components/Base/headless/Combobox/BaseComboboxOption.vue'
import BaseComboboxOptions from '@/Components/Base/headless/Combobox/BaseComboboxOptions.vue'
import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'

import { $t } from '@/utils/i18n'

const emit = defineEmits(['update:modelValue'])

const props = defineProps({
    modelValue: Object,
    options: {
        type: Array,
        default: () => []
    },
    loadOptions: Function,
    createOption: Function
})

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
    if (selected.id === props.modelValue?.id) {
        selected = {
            id: '',
            name: ''
        }
    }

    emit('update:modelValue', selected)
}
</script>

<template>
    <base-combobox :model-value @update:model-value="handleUpdateModelValue">
        <base-combobox-input v-model:query="query"></base-combobox-input>

        <base-combobox-options :options="filteredOptions">
            <div
                v-if="filteredOptions.length === 0 && !isLoading && !queryOption && !props.createOption"
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
                <base-combobox-option :options="filteredOptions"></base-combobox-option>
            </template>
        </base-combobox-options>
    </base-combobox>
</template>
