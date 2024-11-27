<script lang="ts" setup>
import type { IndexParams, PaginationData, SchoolsIndexResource } from '@/types/types'

defineProps<{
    schools: PaginationData<SchoolsIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
