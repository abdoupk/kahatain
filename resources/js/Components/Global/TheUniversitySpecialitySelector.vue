<script lang="ts" setup>
import { useVocationalTrainingStore } from '@/stores/voacational-training'
import { onMounted, ref } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const universitySpeciality = defineModel('universitySpeciality')

const vocationalTrainingStore = useVocationalTrainingStore()

const specialities = ref([])

onMounted(async () => {
    await vocationalTrainingStore.getUniversitySpecialities()

    specialities.value = vocationalTrainingStore.universitySpecialities
})
</script>

<template>
    <base-list-box
        id="university_speciality"
        v-model="universitySpeciality"
        :model-value="universitySpeciality"
        :options="specialities"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('speciality') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
