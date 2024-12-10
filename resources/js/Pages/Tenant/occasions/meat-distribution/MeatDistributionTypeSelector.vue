<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import TheListDropDown from '@/Components/Global/TheListDropDown.vue'

import { $t } from '@/utils/i18n'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: $t('filters.select_an_option')
    }
})

const data = [
    {
        id: 'white_meat',
        name: $t('the_white_meat')
    },
    {
        id: 'red_meat',
        name: $t('the_red_meat')
    }
]
</script>

<template>
    <the-list-drop-down v-model:value="value" :data></the-list-drop-down>
</template>
