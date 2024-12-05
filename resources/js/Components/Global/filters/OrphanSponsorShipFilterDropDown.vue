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

const data = ref([
    {
        label: $t('medical_sponsorship'),
        value: 'medical_sponsorship'
    },
    {
        label: $t('university_scholarship'),
        value: 'university_scholarship'
    },
    {
        label: $t('association_trips'),
        value: 'association_trips'
    },
    {
        label: $t('summer_camp'),
        value: 'summer_camp'
    },
    {
        label: $t('eid_suit'),
        value: 'eid_suit'
    },
    {
        label: $t('private_lessons'),
        value: 'private_lessons'
    },
    {
        label: $t('school_bag'),
        value: 'school_bag'
    }
])
</script>

<template>
    <filter-sponsor-ship-drop-down v-model:value="value" :data></filter-sponsor-ship-drop-down>
</template>
