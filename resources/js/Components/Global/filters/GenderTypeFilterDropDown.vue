<script lang="ts" setup>
import { ref } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const value = defineModel('value')

const data = ref([
    {
        label: $t('male'),
        value: 'male'
    },
    {
        label: $t('female'),
        value: 'female'
    }
])
</script>

<template>
    <base-list-box v-model="value" :options="data" class="mt-2"></base-list-box>
</template>
