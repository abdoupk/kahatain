<script lang="ts" setup>
import { useVocationalTrainingStore } from '@/stores/voacational-training'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

const vocationalTrainingStore = useVocationalTrainingStore()

function loadVocationalTrainingSpecialities(
    query: string,
    setOptions: (results: { id: string; name: string }[]) => void
) {
    vocationalTrainingStore.searchUniversitySpecialities(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <filter-person-drop-down
        v-model="value"
        :load-options="loadVocationalTrainingSpecialities"
    ></filter-person-drop-down>
</template>
