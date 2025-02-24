<script lang="ts" setup>
import { useSchoolsStore } from '@/stores/schools'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const school = defineModel<string>('school', { default: '' })

const schoolsStore = useSchoolsStore()

onMounted(async () => {
    await schoolsStore.getSchools()
})
</script>

<template>
    <base-list-box
        v-model="school"
        :model-value="school"
        :options="schoolsStore.schools"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_school') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
