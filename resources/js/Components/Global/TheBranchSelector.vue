<script lang="ts" setup>
import { useBranchesStore } from '@/stores/branches'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const branch = defineModel<string>('branch', { default: '' })

const branchesStore = useBranchesStore()

onMounted(async () => {
    await branchesStore.getBranches()
})
</script>

<template>
    <base-list-box
        v-model="branch"
        :model-value="branch"
        :options="branchesStore.branches"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_branch') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
