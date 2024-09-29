<script lang="ts" setup>
import type { FilterValueSponsorshipType } from '@/types/types'

import { ref } from 'vue'

import FilterSponsorShipDropDown from '@/Components/Global/filters/FilterSponsorShipDropDown.vue'

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
        label: $t('male'),
        value: 'male'
    },
    {
        label: $t('female'),
        value: 'female'
    }
])
</script>

<template>
    <filter-sponsor-ship-drop-down v-model:value="value" :data></filter-sponsor-ship-drop-down>
</template>
