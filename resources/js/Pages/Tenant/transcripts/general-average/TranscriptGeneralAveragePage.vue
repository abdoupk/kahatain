<script lang="ts" setup>
import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/transcripts/general-average/DataTable.vue'))

defineOptions({
    layout: TheLayout
})

defineProps<{
    grades: unknown
    averages: unknown
}>()
</script>

<template>
    <Head :title="$t('general_average')"></Head>

    <data-table :averages :grades></data-table>
</template>
