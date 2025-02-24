<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { ArchiveIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    items: PaginationData<ArchiveIndexResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="@container">
        <the-desktop-view :items :params></the-desktop-view>

        <the-mobile-view :items :params></the-mobile-view>
    </div>
</template>
