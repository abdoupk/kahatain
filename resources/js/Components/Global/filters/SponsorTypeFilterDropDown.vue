<script lang="ts" setup>
import { ref } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const value = defineModel('value')

const data = ref([
    {
        label: $t('sponsor_types.widower'),
        value: 'widower'
    },
    {
        label: $t('sponsor_types.widow'),
        value: 'widow'
    },
    {
        label: $t('sponsor_types.widows_husband'),
        value: 'widows_husband'
    },
    {
        label: $t('sponsor_types.widowers_wife'),
        value: 'widowers_wife'
    },
    {
        label: $t('sponsor_types.mother_of_a_supported_childhood'),
        value: 'mother_of_a_supported_childhood'
    },
    {
        label: $t('sponsor_types.other'),
        value: 'other'
    }
])
</script>

<template>
    <base-list-box v-model="value" :options="data" class="mt-2"></base-list-box>
</template>
