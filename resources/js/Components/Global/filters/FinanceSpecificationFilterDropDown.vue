<script lang="ts" setup>
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const data = [
    { value: 'drilling_wells', label: $t('drilling_wells') },
    { value: 'monthly_sponsorship', label: $t('monthly_sponsorship') },
    { value: 'eid_el_adha', label: $t('eid_el_adha') },
    { value: 'eid_el_fitr', label: $t('eid_el_fitr') },
    { value: 'zakat_el_fitr', label: $t('zakat_el_fitr') },
    { value: 'zakat', label: $t('zakat') },
    { value: 'other', label: $t('other') },
    { value: 'school_entry', label: $t('school_entry') },
    { value: 'analysis', label: $t('analysis') },
    { value: 'therapy', label: $t('therapy') },
    { value: 'ramadan_basket', label: $t('ramadan_basket') }
]

const value = defineModel('value')
</script>

<template>
    <base-list-box v-model="value" :options="data" class="mt-2"></base-list-box>
</template>
