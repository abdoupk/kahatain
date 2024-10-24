<script lang="ts" setup>
import { useCompetencesStore } from '@/stores/competences'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

const competences = defineModel('competences')

const competencesStore = useCompetencesStore()

const options = ref([])

onMounted(async () => {
    await competencesStore.fetchCompetences()

    options.value = competencesStore.competences
})

const addCompetence = (newTag: string) => {
    const tag = {
        name: newTag,
        id: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
    }

    options.value.push(tag)

    competences.value.push(tag)

    // HandleUpdate(tag)
}
</script>

<template>
    <base-vue-select
        v-model="competences"
        :options="options"
        :placeholder="$t('search_or_add_a_competence')"
        :tag-placeholder="$t('add_this_competence')"
        :taggable="true"
        label="name"
        multiple
        track-by="id"
        @tag="addCompetence"
    ></base-vue-select>
</template>
