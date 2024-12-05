<script lang="ts" setup>
import type { FilterValueSponsorshipType } from '@/types/types'

import { ref } from 'vue'

import FilterSponsorShipDropDown from '@/Components/Global/filters/FilterValueLabelDropDown.vue'

import { $t } from '@/utils/i18n'

const value = defineModel<FilterValueSponsorshipType>('value', {
    default: {
        value: '',
        label: $t('filters.select_an_option')
    }
})

// TODO change to ارمل ....
const data = ref([
    {
        label: $t('father'),
        value: 'father'
    },
    {
        label: $t('mother'),
        value: 'mother'
    },
    {
        label: $t('grand_father'),
        value: 'grand_father'
    },
    {
        label: $t('grand_mother'),
        value: 'grand_mother'
    },
    {
        label: $t('other'),
        value: 'other'
    }
])
</script>

<template>
    <filter-sponsor-ship-drop-down v-model:value="value" :data></filter-sponsor-ship-drop-down>
</template>
