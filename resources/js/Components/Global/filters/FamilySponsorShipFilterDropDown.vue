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

const data = ref([
    {
        label: $t('monthly_allowance'),
        value: 'monthly_allowance'
    },
    {
        label: $t('ramadan_basket'),
        value: 'ramadan_basket'
    },
    {
        label: $t('zakat'),
        value: 'zakat'
    },
    {
        label: $t('housing_assistance'),
        value: 'housing_assistance'
    },
    {
        label: $t('eid_el_adha'),
        value: 'eid_el_adha'
    }
])
</script>

<template>
    <filter-sponsor-ship-drop-down v-model:value="value" :data></filter-sponsor-ship-drop-down>
</template>
