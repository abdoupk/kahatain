<script lang="ts" setup>
import type { OrphansByGenderType, OrphansGroupByCreatedDateType } from '@/types/dashboard'

import OrphansByGender from '@/Pages/Tenant/dashboard/overview/orphans/OrphansByGender.vue'
import OrphansProgress from '@/Pages/Tenant/dashboard/overview/orphans/OrphansProgress.vue'

defineProps<{
    orphansByGender: OrphansByGenderType
    orphansGroupByCreatedDate: OrphansGroupByCreatedDateType
}>()
</script>

<template>
    <orphans-by-gender :orphansByGender></orphans-by-gender>

    <orphans-progress :orphansGroupByCreatedDate></orphans-progress>
</template>
