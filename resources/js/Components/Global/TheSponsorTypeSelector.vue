<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const sponsorTypes = [
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
]

const type = defineModel<string>('type')
</script>

<template>
    <base-list-box
        v-model="type"
        :model-value="type"
        :options="sponsorTypes"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('filters.sponsor_type') })"
    ></base-list-box>
</template>
