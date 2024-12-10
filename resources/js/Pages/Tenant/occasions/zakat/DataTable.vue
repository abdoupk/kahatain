<script lang="ts" setup>
import type { IndexParams, PaginationData, ZakatFamiliesResource } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/occasions/zakat/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/zakat/TheMobileView.vue'

defineProps<{
    families: PaginationData<ZakatFamiliesResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <the-desktop-view :families :params @sort="emit('sort', $event)"></the-desktop-view>

        <the-mobile-view :families :params @sort="emit('sort', $event)"></the-mobile-view>
    </div>
</template>
