<script lang="ts" setup>
import { useCityStore } from '@/stores/city'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

const cityStore = useCityStore()

function loadCities(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    cityStore.searchCities(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadCities"
        :options="[]"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
