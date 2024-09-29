<script lang="ts" setup>
import { useFamiliesStore } from '@/stores/families'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

const familiesStore = useFamiliesStore()

function loadFamilies(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    familiesStore.searchFamilies(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options="loadFamilies"></filter-person-drop-down>
</template>
