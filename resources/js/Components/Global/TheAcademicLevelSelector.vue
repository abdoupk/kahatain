<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'

import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { getAcademicLevelFromId } from '@/utils/helper'

const props = defineProps<{
    academicLevels: AcademicLevelType[]
}>()

const vueSelectAcademicLevel = ref('')

const academicLevel = defineModel('academicLevel')

onMounted(() => {
    vueSelectAcademicLevel.value = getAcademicLevelFromId(academicLevel.value, props.academicLevels)
})

watch(
    () => [academicLevel.value, props.academicLevels],
    () => {
        vueSelectAcademicLevel.value = getAcademicLevelFromId(academicLevel.value, props.academicLevels)
    }
)
</script>

<template>
    <!-- @vue-ignore -->
    <base-vue-select
        id="academic_level"
        v-model:value="vueSelectAcademicLevel"
        :options="academicLevels"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('academic_level') })"
        class="h-full w-full"
        group-label="phase"
        group-values="levels"
        label="name"
        track-by="id"
        @update:value="(value) => (academicLevel = value?.id)"
    >
    </base-vue-select>
</template>
