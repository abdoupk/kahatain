<script lang="ts" setup>
import type { IndexParams, PaginationData, TrashIndexResource } from '@/types/types'

defineProps<{
    items: PaginationData<TrashIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
