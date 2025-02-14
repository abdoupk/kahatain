<script lang="ts" setup>
import { useVocationalTrainingStore } from '@/stores/voacational-training'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

const vocationalTrainingStore = useVocationalTrainingStore()

function loadInstitutes(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    vocationalTrainingStore.searchVocationalTrainingCenters(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadInstitutes"
        :options="[]"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
