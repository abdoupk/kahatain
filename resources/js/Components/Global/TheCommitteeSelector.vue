<script lang="ts" setup>
import { useCommitteesStore } from '@/stores/committees'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

const committees = defineModel('committees')

const committeesStore = useCommitteesStore()

const options = ref([])

onMounted(async () => {
    await committeesStore.getCommittees()

    options.value = committeesStore.committees
})
</script>

<template>
    <base-vue-select
        id="committees"
        v-model="committees"
        :options="options"
        :placeholder="$t('search_a_committee')"
        :tag-placeholder="$t('add_this_committee')"
        label="name"
        multiple
        track-by="id"
    ></base-vue-select>
</template>
