<script lang="ts" setup>
import type { Branch } from '@/types/types'

import { useBranchesStore } from '@/stores/branches'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const branch = defineModel<string>('branch', { default: '' })

const selectedBranch = ref<Branch | string | undefined>('')

const branchesStore = useBranchesStore()

const handleUpdate = (value: Branch) => {
    branch.value = value?.id
}

onMounted(async () => {
    await branchesStore.getBranches()

    selectedBranch.value = branchesStore.findBranchById(branch.value)
})

watch(
    () => branch.value,
    () => {
        selectedBranch.value = branchesStore.findBranchById(branch.value)
    }
)
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedBranch"
        :options="branchesStore.branches"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_branch') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
