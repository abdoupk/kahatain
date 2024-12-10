<script lang="ts" setup>
import type { IndexParams, PaginationData, ZonesIndexResource } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/zones/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/zones/index/TheMobileView.vue'

defineProps<{
    zones: PaginationData<ZonesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :params
            :zones
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :params
            :zones
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-mobile-view>
    </div>
</template>
