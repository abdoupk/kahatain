<script lang="ts" setup>
/* eslint-disable array-element-newline */
import { watch } from 'vue'

import FilterValueLabelDropDown from '@/Components/Global/filters/FilterValueLabelDropDown.vue'

import { $t } from '@/utils/i18n'

const data = [
    { value: 'income', label: $t('income') },
    { value: 'expense', label: $t('expense') }
]

const value = defineModel<string | { value: string; label: string }>('value', {
    default: {
        value: '',
        label: $t('filters.select_an_option')
    }
})

watch(
    () => value.value,
    (newValue) => {
        if (newValue?.id === '')
            value.value = {
                value: '',
                label: $t('filters.select_an_option')
            }
    },
    { immediate: true }
)
</script>

<template>
    <filter-value-label-drop-down v-model:value="value" :data></filter-value-label-drop-down>
</template>
