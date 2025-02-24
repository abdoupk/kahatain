<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

defineProps<{
    academicLevels: AcademicLevelType[]
}>()

const academicLevel = defineModel('academicLevel')
</script>

<template>
    <base-list-box
        id="academic_level"
        v-model="academicLevel"
        :model-value="academicLevel"
        :options="academicLevels"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('academic_level') })"
        group-label="phase"
        group-values="levels"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
