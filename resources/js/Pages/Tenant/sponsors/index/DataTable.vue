<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/sponsors/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/sponsors/index/TheMobileView.vue'

defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :params
            :sponsors
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :params
            :sponsors
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-mobile-view>
    </div>
</template>
