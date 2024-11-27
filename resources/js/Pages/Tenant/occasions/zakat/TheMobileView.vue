<script lang="ts" setup>
import type { IndexParams, PaginationData, ZakatFamiliesResource } from '@/types/types'

const props = defineProps<{
    families: PaginationData<ZakatFamiliesResource>
    params: IndexParams
}>()
</script>

<template></template>
