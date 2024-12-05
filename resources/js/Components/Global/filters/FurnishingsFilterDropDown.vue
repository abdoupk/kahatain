<script lang="ts" setup>
import { watch } from 'vue'

import FilterValueLabelDropDown from '@/Components/Global/filters/FilterValueLabelDropDown.vue'

import { $t } from '@/utils/i18n'

const data = [
    { value: 'television', label: $t('furnishings.television') },
    { value: 'refrigerator', label: $t('furnishings.refrigerator') },
    { value: 'fireplace', label: $t('furnishings.fireplace') },
    { value: 'washing_machine', label: $t('furnishings.washing_machine') },
    { value: 'water_heater', label: $t('furnishings.water_heater') },
    { value: 'oven', label: $t('furnishings.oven') },
    { value: 'wardrobe', label: $t('furnishings.wardrobe') },
    { value: 'cupboard', label: $t('furnishings.cupboard') },
    { value: 'covers', label: $t('furnishings.covers') },
    { value: 'mattresses', label: $t('furnishings.mattresses') }
]

const value = defineModel<string | { value: string; label: string }>('value', {
    default: {
        id: '',
        name: $t('filters.select_an_option')
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
