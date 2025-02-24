<script lang="ts" setup>
import { useSponsorsStore } from '@/stores/sponsors'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

const sponsorsStore = useSponsorsStore()

function loadSponsors(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    sponsorsStore.searchSponsors(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadSponsors"
        :options="[]"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
