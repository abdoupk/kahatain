<script lang="ts" setup>
import type { IndexParams, MembersIndexResource, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/members/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/members/index/TheMobileView.vue'

defineProps<{
    members: PaginationData<MembersIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :members="members"
            :params="params"
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :members
            :params
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-mobile-view>
    </div>
</template>
