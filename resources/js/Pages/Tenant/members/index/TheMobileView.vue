<script lang="ts" setup>
import type { IndexParams, MembersIndexResource, PaginationData } from '@/types/types'

defineProps<{
    members: PaginationData<MembersIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
