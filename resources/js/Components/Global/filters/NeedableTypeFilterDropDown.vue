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

const types = [
    {
        id: 'sponsor',
        name: $t('the_sponsor')
    },
    {
        id: 'orphan',
        name: $t('the_orphan')
    }
]
</script>

<template>
    <filter-value-drop-down v-model:value="value" :data="types"></filter-value-drop-down>
</template>
