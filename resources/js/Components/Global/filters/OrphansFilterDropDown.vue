<script lang="ts" setup>
import { useOrphansStore } from '@/stores/orphans'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

const orphansStore = useOrphansStore()

function loadOrphans(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    orphansStore.searchOrphans(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options="loadOrphans"></filter-person-drop-down>
</template>
