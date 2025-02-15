<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const data = [
    { value: 'television', label: $t('furnishings.television') },
    { value: 'refrigerator', label: $t('furnishings.refrigerator') },
    { value: 'fireplace', label: $t('furnishings.fireplace') },
    { value: 'washing_machine', label: $t('furnishings.washing_machine') },
    { value: 'water_heater', label: $t('furnishings.water_heater') },
    { value: 'oven', label: $t('furnishings.oven') },
    { value: 'wardrobe', label: $t('furnishings.wardrobe') },
    { value: 'cupboard', label: $t('furnishings.cupboard') },
    { value: 'covers', label: $t('furnishings.covers') },
    { value: 'mattresses', label: $t('furnishings.mattresses') }
]

const value = defineModel('value')
</script>

<template>
    <base-list-box v-model="value" :options="data" class="mt-2"></base-list-box>
</template>
