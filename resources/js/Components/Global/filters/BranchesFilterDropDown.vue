<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import { useBranchesStore } from '@/stores/branches'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: $t('filters.select_an_option')
    }
})

const branchesStore = useBranchesStore()

onMounted(() => {
    if (branchesStore.branches.length === 0) {
        branchesStore.getBranches()
    }
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
