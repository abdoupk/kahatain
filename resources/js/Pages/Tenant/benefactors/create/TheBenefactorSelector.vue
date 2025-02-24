<script lang="ts" setup>
import { useBenefactorsStore } from '@/stores/benefactors'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

function loadBenefactors(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    useBenefactorsStore()
        .searchBenefactors(query)
        .then((results) => {
            setOptions(results)
        })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadBenefactors"
        :options="[]"
        class="mt-0"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
