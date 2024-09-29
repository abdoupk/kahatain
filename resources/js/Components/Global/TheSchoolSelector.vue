<script lang="ts" setup>
import type { SchoolType } from '@/types/lessons'

import { useSchoolsStore } from '@/stores/schools'
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const school = defineModel<string>('school', { default: '' })

const selectedSchool = ref<SchoolType | string>('')

const schoolsStore = useSchoolsStore()

const handleUpdate = (value: SchoolType) => {
    school.value = value?.id

    selectedSchool.value = value
}

onMounted(async () => {
    await schoolsStore.getSchools()

    if (school.value) {
        selectedSchool.value = schoolsStore.findSchoolById(school.value)
    }
})
</script>

<template>
    <base-vue-select
        v-model:value="selectedSchool"
        :options="schoolsStore.schools"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_school') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
