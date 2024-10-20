<script lang="ts" setup>
import { useCompetencesStore } from '@/stores/competences'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const competencesStore = useCompetencesStore()

const competences = defineModel<string>('competences', { default: '' })

const selectedCompetences = ref('')

onMounted(async () => {
    await competencesStore.fetchCompetences()

    selectedCompetences.value = competencesStore.findClothesSizeById(c.value)
})

watch(
    () => competences.value,
    () => {
        selectedCompetences.value = sizesStore.findClothesSizeById(size.value)
    }
)

const addTag = (newCompetence: string) => {
    const competence = {
        name: newCompetence,
        code: newCompetence.substring(0, 2) + Math.floor(Math.random() * 10000000)
    }

    selectedCompetences.value.push(competence)

    competences.value.push(competence)
}
</script>

<template>
    <base-vue-select
        v-model:value="selectedCompetences"
        :multiple="true"
        :options="competencesStore.competences"
        :taggable="true"
        label="name"
        placeholder="Search or add a tag"
        tag-placeholder="Add this as new tag"
        track-by="id"
        @tag="addTag"
    ></base-vue-select>
</template>
