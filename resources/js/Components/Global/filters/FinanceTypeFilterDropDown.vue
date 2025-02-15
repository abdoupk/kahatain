<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const data = [
    // eslint-disable-next-line array-element-newline
    { value: 'income', label: $t('income') },
    { value: 'expense', label: $t('expense') }
]

const value = defineModel('value')
</script>

<template>
    <base-list-box v-model="value" :options="data" class="mt-2"></base-list-box>
</template>
