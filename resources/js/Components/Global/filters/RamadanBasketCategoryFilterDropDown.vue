<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import { useSponsorshipsStore } from '@/stores/sponsorships'
import { onMounted, ref } from 'vue'

import FilterValueDropDown from '@/Components/Global/filters/FilterValueDropDown.vue'

import { $t } from '@/utils/i18n'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: $t('filters.select_an_option')
    }
})

const sponsorshipsStore = useSponsorshipsStore()

const data = ref([])

onMounted(async () => {
    await sponsorshipsStore.getRamadanBasketCategories().then((res) => {
        data.value.push({
            id: $t('dont_benefit'),
            name: $t('dont_benefit')
        })

        data.value.push(...res.categories.map((name) => ({ id: name, name })))
    })
})
</script>

<template>
    <filter-value-drop-down v-model="value" :data></filter-value-drop-down>
</template>
