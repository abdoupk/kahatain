<script lang="ts" setup>
import { useCompetencesStore } from '@/stores/competences'
import { Combobox, ComboboxInput, ComboboxOption, ComboboxOptions } from '@headlessui/vue'
import { computed, onMounted, ref } from 'vue'

const competences = defineModel('competences')

const competencesStore = useCompetencesStore()

const options = ref([])

onMounted(async () => {
    await competencesStore.fetchCompetences()

    options.value = competencesStore.competences
})

const query = ref('')

const filteredDepartments = computed(() =>
    query.value === ''
        ? competencesStore.competences
        : competencesStore.competences.filter((department) => {
              return department.name.toLowerCase().includes(query.value.toLowerCase())
          })
)
</script>
<template>
    <combobox v-model="competences" as="div" multiple>
        <ul v-if="competences.length > 0">
            <li v-for="person in competences" :key="person.id">
                {{ person.name }}
            </li>
        </ul>
        <ComboboxInput :displayValue="(department) => department.name" @change="query = $event.target.value" />
        <ComboboxOptions>
            <ComboboxOption v-for="person in filteredDepartments" :key="person.id" :value="person">
                {{ person.name }}
            </ComboboxOption>
        </ComboboxOptions>
    </combobox>
</template>
