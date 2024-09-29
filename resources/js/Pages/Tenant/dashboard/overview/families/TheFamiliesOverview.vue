<script lang="ts" setup>
import type { FamiliesByBranchType, FamiliesByZoneType } from '@/types/dashboard'

import TheFamiliesByBranch from '@/Pages/Tenant/dashboard/overview/families/TheFamiliesByBranch.vue'
import TheFamiliesByZone from '@/Pages/Tenant/dashboard/overview/families/TheFamiliesByZone.vue'

defineProps<{
    familiesByZone: FamiliesByZoneType
    familiesByBranch: FamiliesByBranchType
}>()
</script>

<template>
    <the-families-by-branch :familiesByBranch></the-families-by-branch>

    <the-families-by-zone :familiesByZone></the-families-by-zone>
</template>
