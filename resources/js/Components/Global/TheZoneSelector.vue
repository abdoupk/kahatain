<script lang="ts" setup>
import { useZonesStore } from '@/stores/zones'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const zone = defineModel<string>('zone', { default: '' })

const zonesStore = useZonesStore()

onMounted(async () => {
    await zonesStore.getZones()
})
</script>

<template>
    <base-list-box
        v-model="zone"
        :model-value="zone"
        :options="zonesStore.zones"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_zone') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
