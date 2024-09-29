<script lang="ts" setup>
import type { Zone } from '@/types/types'

import { useZonesStore } from '@/stores/zones'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const zone = defineModel<string>('zone', { default: '' })

const selectedZone = ref<Zone | string | undefined>('')

const zonesStore = useZonesStore()

const handleUpdate = (value: Zone) => {
    zone.value = value?.id
}

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
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedZone"
        :options="zonesStore.zones"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('the_zone') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
