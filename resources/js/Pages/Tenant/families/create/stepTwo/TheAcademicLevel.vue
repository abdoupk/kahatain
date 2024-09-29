<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'

import { ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const academicLevel = defineModel('academicLevel')

defineProps<{
    academicLevels: AcademicLevelType[]
}>()

const vueSelectAcademicLevel = ref({})
</script>

<template>
    <base-vue-select
        id="academic_level"
        v-model:value="vueSelectAcademicLevel"
        :allow-empty="false"
        :options="academicLevels"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_child') })"
        class="h-full w-full"
        group-label="phase"
        group-values="levels"
        label="name"
        track-by="id"
        @update:value="
            (value) => {
                academicLevel = value.id
            }
        "
    >
    </base-vue-select>
</template>
