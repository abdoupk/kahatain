<script lang="ts" setup>
import { useFamiliesStore } from '@/stores/families'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

const familiesStore = useFamiliesStore()

function loadFamilies(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    familiesStore.searchFamilies(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadFamilies"
        :options="[]"
        class="mt-0"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
