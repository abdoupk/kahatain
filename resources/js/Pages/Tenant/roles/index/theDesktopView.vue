<script lang="ts" setup>
import type { IndexParams, PaginationData, RolesIndexResource } from '@/types/types'

defineProps<{
    roles: PaginationData<RolesIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
