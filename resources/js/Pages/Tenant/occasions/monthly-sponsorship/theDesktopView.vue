<script lang="ts" setup>
import type { IndexParams, MonthlySponsorshipFamiliesResource, PaginationData } from '@/types/types'

defineProps<{
    families: PaginationData<MonthlySponsorshipFamiliesResource>
    params: IndexParams
}>()
</script>

<template></template>
