<script lang="ts" setup>
import type { ClothesSizesType, Zone } from '@/types/types'

import { useSizesStore } from '@/stores/sizes'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const size = defineModel<string>('size', { default: '' })

const selectedSize = ref<ClothesSizesType | string | undefined>('')

const sizesStore = useSizesStore()

const handleUpdate = (value: Zone) => {
    size.value = value?.id
}

onMounted(async () => {
    await sizesStore.getClothesSizes()

    selectedSize.value = sizesStore.findClothesSizeById(size.value)
})

watch(
    () => size.value,
    () => {
        selectedSize.value = sizesStore.findClothesSizeById(size.value)
    }
)
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedSize"
        :options="sizesStore.clothesSizes"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
