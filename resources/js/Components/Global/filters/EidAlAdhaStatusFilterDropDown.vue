<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import FilterValueDropDown from '@/Components/Global/filters/FilterValueDropDown.vue'

import { $t } from '@/utils/i18n'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: $t('filters.select_an_option')
    }
})

const statuses = [
    {
        id: 'benefit',
        name: $t('benefit')
    },
    {
        id: 'dont_benefit',
        name: $t('dont_benefit')
    },
    {
        id: 'sacrificed',
        name: $t('sacrificed')
    },
    {
        id: 'meat',
        name: $t('meat')
    },
    {
        id: 'benefactor',
        name: $t('benefactor')
    }
]
</script>

<template>
    <filter-value-drop-down v-model:value="value" :data="statuses"></filter-value-drop-down>
</template>
