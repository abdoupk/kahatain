<script lang="ts" setup>
import SponsorsFilterDropDown from '@/Components/Global/filters/SponsorsFilterDropDown.vue'

const orphan = defineModel('sponsor')
</script>

<template>
    <sponsors-filter-drop-down v-model="orphan" class="mt-0"></sponsors-filter-drop-down>
</template>
