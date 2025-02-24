<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const value = defineModel('value')

const statuses = [
    {
        id: 'pending',
        name: $t('pending')
    },
    {
        id: 'in_progress',
        name: $t('in_progress')
    },
    {
        id: 'completed',
        name: $t('completed')
    },
    {
        id: 'rejected',
        name: $t('rejected')
    }
]
</script>

<template>
    <base-list-box v-model="value" :options="statuses" class="mt-2" label-key="name" value-key="id"></base-list-box>
</template>
