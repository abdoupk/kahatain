<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import { useSizesStore } from '@/stores/sizes'
import { onMounted } from 'vue'

import FilterValueDropDown from '@/Components/Global/filters/FilterValueDropDown.vue'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: ''
    }
})

const sizesStore = useSizesStore()

onMounted(async () => {
    await sizesStore.getClothesSizes()
})
</script>

<template>
    <filter-value-drop-down v-model:value="value" :data="sizesStore.clothesSizes"></filter-value-drop-down>
</template>
