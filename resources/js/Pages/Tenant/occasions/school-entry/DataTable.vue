<script lang="ts" setup>
import type { IndexParams, PaginationData, SchoolEntryOrphansResource } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/occasions/school-entry/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/school-entry/TheMobileView.vue'

defineProps<{
    orphans: PaginationData<SchoolEntryOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <the-desktop-view :orphans :params @sort="emit('sort', $event)"></the-desktop-view>

        <the-mobile-view :orphans :params></the-mobile-view>
    </div>
</template>
