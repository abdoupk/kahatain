<script lang="ts" setup>
import type { Branch } from '@/types/types'

import { useBranchesStore } from '@/stores/branches'
import { onMounted, ref, watch } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const branch = defineModel<string>('branch', { default: '' })

const selectedBranch = ref<Branch | string | undefined>('')

const branchesStore = useBranchesStore()

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
    <base-list-box
        v-model="branch"
        :model-value="selectedBranch"
        :options="branchesStore.branches"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_branch') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
