<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/sponsors/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/sponsors/index/TheMobileView.vue'

defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <the-desktop-view :params :sponsors @sort="emit('sort', $event)"></the-desktop-view>

        <the-mobile-view :params :sponsors></the-mobile-view>
    </div>
</template>
