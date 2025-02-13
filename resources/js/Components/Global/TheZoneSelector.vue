<script lang="ts" setup>
import type { Zone } from '@/types/types'

import { useZonesStore } from '@/stores/zones'
import { onMounted, ref, watch } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const zone = defineModel<string>('zone', { default: '' })

const selectedZone = ref<Zone | string | undefined>('')

const zonesStore = useZonesStore()

onMounted(async () => {
    await zonesStore.getZones()

    selectedZone.value = zonesStore.findZoneById(zone.value)
})

watch(
    () => zone.value,
    () => {
        selectedZone.value = zonesStore.findZoneById(zone.value)
    }
)
</script>

<template>
    <base-list-box
        v-model="zone"
        :model-value="selectedZone"
        :options="zonesStore.zones"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_zone') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
