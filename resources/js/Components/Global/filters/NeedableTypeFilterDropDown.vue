<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const value = defineModel('value')

const types = [
    {
        id: 'sponsor',
        name: $t('the_sponsor')
    },
    {
        id: 'orphan',
        name: $t('the_orphan')
    }
]
</script>

<template>
    <base-list-box v-model="value" :options="types" class="mt-2" label-key="name" value-key="id"></base-list-box>
</template>
