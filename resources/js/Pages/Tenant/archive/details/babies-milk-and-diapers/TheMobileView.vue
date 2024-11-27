<script lang="ts" setup>
import type { BabiesMilkAndDiapersResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    orphans: PaginationData<BabiesMilkAndDiapersResource>
    params: IndexParams
}>()
</script>

<template></template>
