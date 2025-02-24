<script lang="ts" setup>
import type { EidAlAdhaFamiliesResource, IndexParams, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/occasions/eid-al-adha/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/eid-al-adha/TheMobileView.vue'

defineProps<{
    families: PaginationData<EidAlAdhaFamiliesResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort', 'change-status'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :families
            :params
            @sort="emit('sort', $event)"
            @change-status="emit('change-status', $event)"
        ></the-desktop-view>

        <the-mobile-view :families :params @change-status="emit('change-status', $event)"></the-mobile-view>
    </div>
</template>
