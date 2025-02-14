<script lang="ts" setup>
import { useAcademicLevelsStore } from '@/stores/academic-level'
import { onMounted, ref } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const value = defineModel('value')

const academicLevelsStore = useAcademicLevelsStore()

const data = ref([])

onMounted(async () => {
    await academicLevelsStore.getAcademicLevelsForOrphansForSelectCollege().then((res) => {
        data.value = res[0].levels
    })
})
</script>

<template>
    <base-list-box v-model="value" :options="data" class="mt-2" label-key="name" value-key="id"></base-list-box>
</template>
