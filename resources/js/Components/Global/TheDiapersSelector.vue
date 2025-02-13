<script lang="ts" setup>
import { useInventoryStore } from '@/stores/inventory'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const diaper = defineModel<string>('diaper', { default: '' })

const inventoryStore = useInventoryStore()

onMounted(async () => {
    await inventoryStore.getDiapers()
})
</script>

<template>
    <base-list-box
        v-model="diaper"
        :model-value="diaper"
        :options="inventoryStore.diapers"
        :placeholder="$t('auth.placeholders.fill', { attribute: $t('diapers_type') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
