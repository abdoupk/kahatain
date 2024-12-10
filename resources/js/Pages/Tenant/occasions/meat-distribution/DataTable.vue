<script lang="ts" setup>
import type { IndexParams, MeatDistributionFamiliesResource, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/occasions/meat-distribution/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/meat-distribution/TheMobileView.vue'

defineProps<{
    families: PaginationData<MeatDistributionFamiliesResource>
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
