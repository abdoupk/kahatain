<script lang="ts" setup>
import { useBranchesStore } from '@/stores/branches'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const value = defineModel('value')

const branchesStore = useBranchesStore()

onMounted(async () => {
    await branchesStore.getBranches()
})
</script>

<template>
    <base-list-box
        v-model="value"
        :options="branchesStore.branches"
        class="mt-2"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
