<script lang="ts" setup>
import FamiliesFilterDropDown from '@/Components/Global/filters/FamiliesFilterDropDown.vue'

const family = defineModel('family')
</script>

<template>
    <families-filter-drop-down v-model="family" class="mt-0"></families-filter-drop-down>
</template>
