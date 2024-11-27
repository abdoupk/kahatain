<script lang="ts" setup>
import type { IndexParams, OrphansTranscriptsIndexResource, PaginationData } from '@/types/types'

defineProps<{
    orphans: PaginationData<OrphansTranscriptsIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
