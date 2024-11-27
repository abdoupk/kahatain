<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
}>()
</script>

<template></template>
