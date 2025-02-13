<script lang="ts" setup>
import { useBenefactorsStore } from '@/stores/benefactors'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

function loadBenefactors(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    useBenefactorsStore()
        .searchBenefactors(query)
        .then((results) => {
            setOptions(results)
        })
}
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options="loadBenefactors" class="mt-0"></filter-person-drop-down>
</template>
