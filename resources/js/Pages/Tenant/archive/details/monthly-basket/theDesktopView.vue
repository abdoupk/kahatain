<script lang="ts" setup>
import type { IndexParams, PaginationData, RamadanBasketFamiliesResource } from '@/types/types'

defineProps<{
    families: PaginationData<RamadanBasketFamiliesResource>
    params: IndexParams
}>()
</script>

<template></template>
