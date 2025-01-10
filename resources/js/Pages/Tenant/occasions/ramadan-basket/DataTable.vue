<script lang="ts" setup>
import type { IndexParams, PaginationData, RamadanBasketFamiliesResource } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/occasions/ramadan-basket/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/ramadan-basket/TheMobileView.vue'

defineProps<{
    families: PaginationData<RamadanBasketFamiliesResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <the-desktop-view :families :params @sort="emit('sort', $event)"></the-desktop-view>

        <the-mobile-view :families :params></the-mobile-view>
    </div>
</template>
