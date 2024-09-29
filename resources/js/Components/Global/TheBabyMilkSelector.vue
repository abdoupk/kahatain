<script lang="ts" setup>
import type { BabyMilk } from '@/types/types'

import { useInventoryStore } from '@/stores/inventory'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const babyMilk = defineModel<string>('babyMilk', { default: '' })

const selectedBabyMilk = ref<BabyMilk | string | undefined>('')

const inventoryStore = useInventoryStore()

const handleUpdate = (value: BabyMilk) => {
    babyMilk.value = value?.id
}

onMounted(async () => {
    await inventoryStore.getBabyMilk()

    selectedBabyMilk.value = inventoryStore.findBabyMilkById(babyMilk.value)
})

watch(
    () => babyMilk.value,
    () => {
        selectedBabyMilk.value = inventoryStore.findBabyMilkById(babyMilk.value)
    }
)
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedBabyMilk"
        :options="inventoryStore.babyMilk"
        :placeholder="$t('auth.placeholders.fill', { attribute: $t('baby_milk_type') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
