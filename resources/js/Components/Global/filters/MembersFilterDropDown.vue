<script lang="ts" setup>
import { useMembersStore } from '@/stores/members'

import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})

const membersStore = useMembersStore()

function loadFamilies(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    membersStore.searchMembers(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options="loadFamilies"></filter-person-drop-down>
</template>
