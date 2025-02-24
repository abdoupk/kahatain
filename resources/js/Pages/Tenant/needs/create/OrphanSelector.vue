<script lang="ts" setup>
import OrphansFilterDropDown from '@/Components/Global/filters/OrphansFilterDropDown.vue'

const orphan = defineModel('orphan')
</script>

<template>
    <orphans-filter-drop-down v-model="orphan" class="mt-0"></orphans-filter-drop-down>
</template>
