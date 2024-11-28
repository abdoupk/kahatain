<script lang="ts" setup>
import type { FilterValueType } from '@/types/types'

import { useZakatStore } from '@/stores/zakat'
import { onMounted } from 'vue'

import ZakatListDropDown from '@/Pages/Tenant/occasions/zakat/ZakatListDropDown.vue'

import { $t } from '@/utils/i18n'

const value = defineModel<FilterValueType>('value', {
    default: {
        id: '',
        name: $t('filters.select_an_option')
    }
})

const zakatStore = useZakatStore()

onMounted(async () => {
    await zakatStore.getZakats()
})
</script>

<template>
    <zakat-list-drop-down v-model:value="value" :data="zakatStore.zakats"></zakat-list-drop-down>
</template>
