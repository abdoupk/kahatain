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
        id: 'pending',
        name: $t('pending')
    },
    {
        id: 'in_progress',
        name: $t('in_progress')
    },
    {
        id: 'completed',
        name: $t('completed')
    },
    {
        id: 'rejected',
        name: $t('rejected')
    }
]
</script>

<template>
    <filter-value-drop-down v-model:value="value" :data="statuses"></filter-value-drop-down>
</template>
