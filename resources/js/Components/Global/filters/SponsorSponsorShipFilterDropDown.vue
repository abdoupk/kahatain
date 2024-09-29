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
        label: $t('medical_sponsorship'),
        value: 'medical_sponsorship'
    },
    {
        label: $t('literacy_lessons'),
        value: 'literacy_lessons'
    },
    {
        label: $t('direct_sponsorship'),
        value: 'direct_sponsorship'
    },
    {
        label: $t('project_support'),
        value: 'project_support'
    }
])
</script>

<template>
    <filter-sponsor-ship-drop-down v-model:value="value" :data></filter-sponsor-ship-drop-down>
</template>
