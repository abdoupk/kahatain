<script lang="ts" setup>
import { useSizesStore } from '@/stores/sizes'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const value = defineModel('value')

const sizesStore = useSizesStore()

onMounted(async () => {
    await sizesStore.getClothesSizes()
})
</script>

<template>
    <base-list-box
        v-model="value"
        :options="sizesStore.clothesSizes"
        class="mt-2"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
