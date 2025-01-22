<script lang="ts" setup>
import type { ClothesSizesType, Zone } from '@/types/types'

import { useSizesStore } from '@/stores/sizes'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

const size = defineModel<string>('size', { default: '' })

const selectedSize = ref<ClothesSizesType | string | undefined>('')

const sizesStore = useSizesStore()

const handleUpdate = (value: Zone) => {
    if (value) {
        size.value = value.id
    } else {
        size.value = null
    }
}

onMounted(async () => {
    await sizesStore.getShoesSizes()

    selectedSize.value = sizesStore.findShoesSizeById(size.value)
})

watch(
    () => size.value,
    () => {
        selectedSize.value = sizesStore.findShoesSizeById(size.value)
    }
)
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedSize"
        :options="sizesStore.shoesSizes"
        :placeholder="$t('auth.placeholders.fill', { attribute: $t('shoes_size') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
