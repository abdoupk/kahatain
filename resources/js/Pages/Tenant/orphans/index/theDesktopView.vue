<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

defineProps<{
    orphans: PaginationData<OrphansIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
