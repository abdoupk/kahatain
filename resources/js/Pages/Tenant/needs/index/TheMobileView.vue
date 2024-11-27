<script lang="ts" setup>
import type { IndexParams, NeedsIndexResource, PaginationData } from '@/types/types'

defineProps<{
    needs: PaginationData<NeedsIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
