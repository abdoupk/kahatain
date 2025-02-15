<script lang="ts" setup>
import { useOrphansStore } from '@/stores/orphans'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

const orphansStore = useOrphansStore()

function loadOrphans(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    orphansStore.searchOrphans(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadOrphans"
        :options="[]"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
