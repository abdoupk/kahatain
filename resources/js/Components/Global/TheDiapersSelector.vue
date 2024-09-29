<script lang="ts" setup>
import type { Diaper } from '@/types/types'

import { useInventoryStore } from '@/stores/inventory'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const diaper = defineModel<string>('diaper', { default: '' })

const selectedDiaper = ref<Diaper | string | undefined>('')

const inventoryStore = useInventoryStore()

const handleUpdate = (value: Diaper) => {
    diaper.value = value?.id
}

onMounted(async () => {
    await inventoryStore.getDiapers()

    selectedDiaper.value = inventoryStore.findDiaperById(diaper.value)
})

watch(
    () => diaper.value,
    () => {
        selectedDiaper.value = inventoryStore.findDiaperById(diaper.value)
    }
)
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedDiaper"
        :options="inventoryStore.diapers"
        :placeholder="$t('auth.placeholders.fill', { attribute: $t('diapers_type') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
