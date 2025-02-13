<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { financialTransactionSpecifications } from '@/utils/constants'
import { $t } from '@/utils/i18n'

const specification = defineModel<string>('specification', { default: '' })
</script>

<template>
    <base-list-box
        v-model="specification"
        :model-value="specification"
        :options="financialTransactionSpecifications"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('validation.attributes.the_status') })"
    ></base-list-box>
</template>
