<script lang="ts" setup>
import type { ClothesSizesType, Zone } from '@/types/types'

import { useSizesStore } from '@/stores/sizes'
import { onMounted, ref, watch } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

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
        :placeholder="$t('auth.placeholders.fill', { attribute: $t('pants_size') })"
        label="name"
        track-by="id"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
