<script lang="ts" setup>
import type { BranchesIndexResource, IndexParams, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/branches/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/branches/index/TheMobileView.vue'

import NoResultsFound from '@/Components/Global/NoResultsFound.vue'

defineProps<{
    branches: PaginationData<BranchesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div v-if="branches.data.length > 0" class="@container">
        <the-desktop-view
            :branches
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :branches
            :params
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-mobile-view>
    </div>

    <div v-else class="intro-x mt-12 flex flex-col items-center justify-center">
        <no-results-found></no-results-found>
    </div>
</template>
