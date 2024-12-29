<script lang="ts" setup>
import { useVocationalTrainingStore } from '@/stores/voacational-training'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const universitySpeciality = defineModel('universitySpeciality')

const vocationalTrainingStore = useVocationalTrainingStore()

const vueSelectUniversitySpeciality = ref('')

const specialities = ref([])

onMounted(async () => {
    await vocationalTrainingStore.getUniversitySpecialities()

    specialities.value = vocationalTrainingStore.universitySpecialities

    vueSelectUniversitySpeciality.value = specialities.value.find(
        (speciality) => Number(speciality.id) === universitySpeciality.value
    )
})

watch(
    () => [universitySpeciality.value],
    (value) => {
        vueSelectUniversitySpeciality.value = specialities.value.find(
            (speciality) => Number(speciality.id) === value[0]
        )
    }
)
</script>

<template>
    <div>
        <!-- @vue-ignore -->
        <base-vue-select
            id="university_speciality"
            v-model:value="vueSelectUniversitySpeciality"
            :allow-empty="false"
            :options="specialities"
            :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('speciality') })"
            class="h-full w-full"
            label="name"
            track-by="id"
            @update:value="(value) => (universitySpeciality = value.id)"
        >
        </base-vue-select>
    </div>
</template>
