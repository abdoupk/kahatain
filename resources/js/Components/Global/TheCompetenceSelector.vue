<script lang="ts" setup>
import { useCompetencesStore } from '@/stores/competences'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { generateUUID } from '@/utils/helper'
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
        id: generateUUID()
    }

    options.value.push(tag)

    competences.value.push(tag)
}
</script>

<template>
    <base-vue-select
        id="competences"
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
