<script lang="ts" setup>
import type { IndexParams, InventoryIndexResource, PaginationData } from '@/types/types'

defineProps<{
    items: PaginationData<InventoryIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
