<script lang="ts" setup>
import { BenefactorsIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    benefactors: PaginationData<BenefactorsIndexResource>
    params: IndexParams
}>()
</script>

<template></template>
