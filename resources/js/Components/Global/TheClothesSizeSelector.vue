<script lang="ts" setup>
import { useSizesStore } from '@/stores/sizes'
import { onMounted } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const size = defineModel<string>('size')

const sizesStore = useSizesStore()

onMounted(async () => {
    await sizesStore.getClothesSizes()
})
</script>

<template>
    <base-list-box
        v-model="size"
        :model-value="size"
        :options="sizesStore.clothesSizes"
        :placeholder="$t('auth.placeholders.fill', { attribute: $t('pants_size') })"
        label-key="name"
        value-key="id"
    ></base-list-box>
</template>
