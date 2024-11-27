<script lang="ts" setup>
import type { CommitteesIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    committees: PaginationData<CommitteesIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
