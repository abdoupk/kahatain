<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { onMounted, ref } from 'vue'

import FilterValueDropDown from '@/Components/Global/filters/FilterValueDropDown.vue'

import { $t } from '@/utils/i18n'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: $t('filters.select_an_option')
    }
})

const academicLevelsStore = useAcademicLevelsStore()

const data = ref([])

onMounted(async () => {
    await academicLevelsStore.getAcademicLevelsForOrphansForSelectCollege().then((res) => {
        data.value = res[0].levels
    })
})
</script>

<template>
    <filter-value-drop-down v-model:value="value" :data></filter-value-drop-down>
</template>
