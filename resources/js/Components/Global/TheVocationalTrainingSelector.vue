<script lang="ts" setup>
import { useVocationalTrainingStore } from '@/stores/voacational-training'
import { onMounted, ref } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const vocationalTraining = defineModel('vocationalTraining')

const vocationalTrainingStore = useVocationalTrainingStore()

const vueSelectVocationalTraining = ref('')

const specialities = ref([])

onMounted(async () => {
    await vocationalTrainingStore.getVocationalTrainingSpecialities()

    specialities.value = vocationalTrainingStore.vocationalTrainingSpecialities
})
</script>

<template>
    <base-list-box
        id="vocational_training"
        v-model="vocationalTraining"
        :model-value="vocationalTraining"
        :options="specialities"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('academic_level') })"
        group-label="division"
        group-values="specialities"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
