<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { IndexParams, PaginationData, SchoolsIndexResource } from '@/types/types'

defineProps<{
    schools: PaginationData<SchoolsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :params
            :schools
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :params
            :schools
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-mobile-view>
    </div>
</template>
