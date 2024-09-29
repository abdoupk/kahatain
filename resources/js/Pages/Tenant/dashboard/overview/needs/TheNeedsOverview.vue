<script lang="ts" setup>
import type { NeedsByCreatedDateType, NeedsByNeedableTypeType } from '@/types/dashboard'

import NeedsByNeedableType from '@/Pages/Tenant/dashboard/overview/needs/NeedsByNeedableType.vue'
import NeedsProgress from '@/Pages/Tenant/dashboard/overview/needs/NeedsProgress.vue'

defineProps<{
    needsByCreatedDate: NeedsByCreatedDateType
    needsByNeedableType: NeedsByNeedableTypeType
}>()
</script>

<template>
    <needs-by-needable-type :needsByNeedableType></needs-by-needable-type>

    <needs-progress :needsByCreatedDate></needs-progress>
</template>
