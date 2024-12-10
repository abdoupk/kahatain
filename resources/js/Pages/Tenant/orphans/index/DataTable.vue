<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/orphans/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/orphans/index/TheMobileView.vue'

defineProps<{
    orphans: PaginationData<OrphansIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :orphans
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :orphans
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-mobile-view>
    </div>
</template>
