<script lang="ts" setup>
import { useSchoolsStore } from '@/stores/schools'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

function loadUniversities(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    useSchoolsStore()
        .searchUniversities(query)
        .then((results) => {
            setOptions(results)
        })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadUniversities"
        :options="[]"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
