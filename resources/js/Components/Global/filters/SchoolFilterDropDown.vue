<script lang="ts" setup>
import { useSchoolsStore } from '@/stores/schools'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

const schoolsStore = useSchoolsStore()

function loadSchools(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    schoolsStore.searchAllPhasesSchools(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options="loadSchools"></filter-person-drop-down>
</template>
