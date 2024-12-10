<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { IndexParams, OrphansTranscriptsIndexResource, PaginationData } from '@/types/types'

defineProps<{
    orphans: PaginationData<OrphansTranscriptsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showCreateModal', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :orphans
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-create-modal="emit('showCreateModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :orphans
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-create-modal="emit('showCreateModal', $event)"
        ></the-mobile-view>
    </div>
</template>
