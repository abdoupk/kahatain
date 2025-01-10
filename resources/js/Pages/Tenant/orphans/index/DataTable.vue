<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/orphans/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/orphans/index/TheMobileView.vue'

defineProps<{
    orphans: PaginationData<OrphansIndexResource>
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
