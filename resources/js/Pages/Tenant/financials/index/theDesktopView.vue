<script lang="ts" setup>
import type { FinancialTransactionsIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    finances: PaginationData<FinancialTransactionsIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
