<script lang="ts" setup>
import type { BabiesMilkAndDiapersResource, IndexParams, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/occasions/babies/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/babies/TheMobileView.vue'

defineProps<{
    orphans: PaginationData<BabiesMilkAndDiapersResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <the-desktop-view :orphans :params @sort="emit('sort', $event)"></the-desktop-view>

        <the-mobile-view :orphans :params @sort="emit('sort', $event)"></the-mobile-view>
    </div>
</template>
