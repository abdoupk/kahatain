<script lang="ts" setup>
import type { EidAlAdhaFamiliesResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    families: PaginationData<EidAlAdhaFamiliesResource>
    params: IndexParams
}>()
</script>

<template></template>
