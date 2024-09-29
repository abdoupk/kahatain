<script lang="ts" setup>
import { useVocationalTrainingStore } from '@/stores/voacational-training'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { getVocationalTrainingSpecialityFromId } from '@/utils/helper'

const vocationalTraining = defineModel('vocationalTraining')

const vocationalTrainingStore = useVocationalTrainingStore()

const vueSelectVocationalTraining = ref('')

const specialities = ref([])

onMounted(async () => {
    await vocationalTrainingStore.getVocationalTrainingSpecialities()

    specialities.value = vocationalTrainingStore.vocationalTrainingSpecialities
})

onMounted(() => {
    vueSelectVocationalTraining.value = getVocationalTrainingSpecialityFromId(
        vocationalTraining.value,
        specialities.value
    )
})

watch(
    () => [vocationalTraining.value],
    (value) => {
        vueSelectVocationalTraining.value = getVocationalTrainingSpecialityFromId(value, specialities.value)
    }
)
</script>

<template>
    <div>
        <!-- @vue-ignore -->
        <base-vue-select
            id="vocational_training"
            v-model:value="vueSelectVocationalTraining"
            :allow-empty="false"
            :options="specialities"
            :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('speciality') })"
            class="h-full w-full"
            group-label="division"
            group-values="specialities"
            label="name"
            track-by="id"
            @update:value="(value) => (vocationalTraining = value.id)"
        >
        </base-vue-select>
    </div>
</template>
