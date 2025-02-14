<script lang="ts" setup>
import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'

defineProps<{
    loadOptions: (query: string, setOptions: (results: { id: string; name: string }[]) => void) => void
}>()

const value = defineModel('value')
</script>

<template>
    <base-combobox
        v-model="value"
        :load-options
        :options="[]"
        class="mt-0"
        label-key="name"
        value-key="id"
    ></base-combobox>
</template>
