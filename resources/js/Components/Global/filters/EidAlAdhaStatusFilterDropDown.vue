<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const value = defineModel('value')

const statuses = [
    {
        id: 'benefit',
        name: $t('benefit')
    },
    {
        id: 'dont_benefit',
        name: $t('dont_benefit')
    },
    {
        id: 'sacrificed',
        name: $t('sacrificed')
    },
    {
        id: 'meat',
        name: $t('meat')
    },
    {
        id: 'benefactor',
        name: $t('benefactor')
    }
]
</script>

<template>
    <base-list-box v-model="value" :options="statuses" class="mt-2" label-key="name" value-key="id"></base-list-box>
</template>
