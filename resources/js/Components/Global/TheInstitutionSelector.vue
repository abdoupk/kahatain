<script lang="ts" setup>
import FilterPersonDropDown from '@/Components/Global/filters/FilterPersonDropDown.vue'

defineProps<{
    loadOptions: (query: string, setOptions: (results: { id: string; name: string }[]) => void) => void
}>()

const value = defineModel<{ id: string; name: string }>('value', {
    default: {
        id: '',
        name: ''
    }
})
</script>

<template>
    <filter-person-drop-down v-model="value" :load-options class="!mt-0"></filter-person-drop-down>
</template>
