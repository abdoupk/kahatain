<script lang="ts" setup>
import { useCommitteesStore } from '@/stores/committees'
import { onMounted, ref } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const committees = defineModel('committees')

const committeesStore = useCommitteesStore()

const options = ref([])

onMounted(async () => {
    await committeesStore.getCommittees()
})
</script>

<template>
    <base-list-box
        v-model="committees"
        :model-value="committees"
        :options="committeesStore.committees"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_committee') })"
        label-key="name"
        multiple
        value-key="id"
    ></base-list-box>
</template>
