<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { FinancialTransactionsIndexResource, IndexParams, PaginationData } from '@/types/types'

defineProps<{
    finances: PaginationData<FinancialTransactionsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showDetailsModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :finances
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :finances
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-mobile-view>
    </div>
</template>
