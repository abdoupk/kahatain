<script lang="ts" setup>
import type { SubjectType } from '@/types/types'

import { useSubjectsStore } from '@/stores/subjects'
import { onMounted, ref, watch } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const subject = defineModel<number | undefined>('subject')

const subjectsStore = useSubjectsStore()

const props = defineProps<{
    subjects: SubjectType[]
}>()

const subjects = ref(props.subjects)

watch(
    () => props.subjects,
    (value) => {
        if (value) {
            subjects.value = value
        } else subjects.value = subjectsStore.subjects
    }
)

onMounted(async () => {
    await subjectsStore.getSubjects()
})
</script>

<template>
    <base-list-box
        v-model="subject"
        :model-value="subject"
        :options="subjects"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_subject') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
