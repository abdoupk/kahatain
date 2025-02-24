<script lang="ts" setup>
import { useMembersStore } from '@/stores/members'

import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

const value = defineModel('value')

const membersStore = useMembersStore()

function loadMembers(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    membersStore.searchMembers(query).then((results) => {
        setOptions(results)
    })
}
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options="loadMembers"
        :options="useMembersStore().members"
        class="mt-0"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
