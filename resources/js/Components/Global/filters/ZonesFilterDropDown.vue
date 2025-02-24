<script lang="ts" setup>
import { useZonesStore } from '@/stores/zones'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const value = defineModel('value')

const zonesStore = useZonesStore()

onMounted(() => {
    if (zonesStore.zones.length === 0) {
        zonesStore.getZones()
    }
})
</script>

<template>
    <base-list-box
        v-model="value"
        :options="zonesStore.zones"
        class="mt-2"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
