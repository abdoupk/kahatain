<script lang="ts" setup>
import { useSponsorsStore } from '@/stores/sponsors'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

const sponsorsStore = useSponsorsStore()

function loadSponsors(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    sponsorsStore.searchSponsors(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options="loadSponsors"></filter-person-drop-down>
</template>
