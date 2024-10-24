<script lang="ts" setup>
import type { SubjectType } from '@/types/types'

import { useSubjectsStore } from '@/stores/subjects'
import { ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const subject = defineModel<number | undefined>('subject')

const selectedSubject = ref<SubjectType | number | string | undefined>()

const subjectsStore = useSubjectsStore()

const props = defineProps<{
    subjects: SubjectType[]
}>()

const subjects = ref(props.subjects)

const handleUpdate = (value: SubjectType) => {
    subject.value = value?.id

    selectedSubject.value = value
}

watch(
    () => props.subjects,
    (value) => {
        if (value) {
            subjects.value = value
        } else subjects.value = subjectsStore.subjects
    }
)
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedSubject"
        :options="subjects"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_subject') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
