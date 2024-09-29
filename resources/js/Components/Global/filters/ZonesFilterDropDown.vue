<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import { useZonesStore } from '@/stores/zones'
import { onMounted } from 'vue'

import FilterValueDropDown from '@/Components/Global/filters/FilterValueDropDown.vue'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: ''
    }
})

const zonesStore = useZonesStore()

onMounted(() => {
    if (zonesStore.zones.length === 0) {
        zonesStore.getZones()
    }
})
</script>

<template>
    <filter-value-drop-down v-model:value="value" :data="zonesStore.zones"></filter-value-drop-down>
</template>
