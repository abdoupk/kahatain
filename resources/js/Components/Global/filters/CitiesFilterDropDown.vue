<script lang="ts" setup>
import { useCityStore } from '@/stores/city'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

const cityStore = useCityStore()

function loadFamilies(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    cityStore.searchCities(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options="loadFamilies"></filter-person-drop-down>
</template>
