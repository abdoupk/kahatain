<script lang="ts" setup>
import type { ArchiveIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    items: PaginationData<ArchiveIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
