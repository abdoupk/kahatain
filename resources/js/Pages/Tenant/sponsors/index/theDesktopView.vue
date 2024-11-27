<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
