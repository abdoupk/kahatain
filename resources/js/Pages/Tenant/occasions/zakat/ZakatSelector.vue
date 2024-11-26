<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import { useZakatStore } from '@/stores/zakat'
import { onMounted } from 'vue'

import FilterValueDropDown from '@/Components/Global/filters/FilterValueDropDown.vue'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: ''
    }
})

const zakatStore = useZakatStore()

onMounted(async () => {
    await zakatStore.getZakats()
})
</script>

<template>
    <filter-value-drop-down v-model:value="value" :data="zakatStore.zakats"></filter-value-drop-down>
</template>
