<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    families: PaginationData<FamiliesIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
