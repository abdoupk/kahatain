<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { EidAlAdhaFamiliesResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    families: PaginationData<EidAlAdhaFamiliesResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="@container">
        <the-desktop-view :families :params></the-desktop-view>

        <the-mobile-view :families :params></the-mobile-view>
    </div>
</template>
