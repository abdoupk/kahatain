<script lang="ts" setup>
import type { PaginationData } from '@/types/types'

import TheLayout from '@/Layouts/TheLayout.vue'

import ArchivesDataTable from '@/Pages/Tenant/families/details/history/ArchivesDataTable.vue'
import NeedsDataTable from '@/Pages/Tenant/families/details/history/NeedsDataTable.vue'

defineOptions({
    layout: TheLayout
})

defineProps<{
    archives: PaginationData<unknown>
    needs: PaginationData<unknown>
    familyId: string
}>()
</script>

<template>
    <archives-data-table :archives :familyId :needs-meta="needs.meta"></archives-data-table>

    <needs-data-table :archives-meta="archives.meta" :familyId :needs></needs-data-table>
</template>
