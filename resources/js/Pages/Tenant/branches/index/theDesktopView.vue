<script lang="ts" setup>
import type { BranchesIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    branches: PaginationData<BranchesIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
