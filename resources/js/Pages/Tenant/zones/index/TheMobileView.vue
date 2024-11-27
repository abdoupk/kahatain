<script lang="ts" setup>
import type { IndexParams, PaginationData, ZonesIndexResource } from '@/types/types'

defineProps<{
    zones: PaginationData<ZonesIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
