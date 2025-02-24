<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { BabiesMilkAndDiapersResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    orphans: PaginationData<BabiesMilkAndDiapersResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="@container">
        <the-desktop-view :orphans :params></the-desktop-view>

        <the-mobile-view :orphans :params></the-mobile-view>
    </div>
</template>
