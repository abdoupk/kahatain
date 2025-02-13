<script lang="ts" setup>
import { useInventoryStore } from '@/stores/inventory'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const babyMilk = defineModel<string>('babyMilk', { default: '' })

const inventoryStore = useInventoryStore()

onMounted(async () => {
    await inventoryStore.getBabyMilk()
})
</script>

<template>
    <!--  @vue-ignore  -->
    <base-list-box
        v-model="babyMilk"
        :model-value="babyMilk"
        :options="inventoryStore.babyMilk"
        :placeholder="$t('auth.placeholders.fill', { attribute: $t('baby_milk_type') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
