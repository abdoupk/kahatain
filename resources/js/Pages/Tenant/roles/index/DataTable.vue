<script lang="ts" setup>
import type { IndexParams, PaginationData, RolesIndexResource } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/roles/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/roles/index/TheMobileView.vue'

defineProps<{
    roles: PaginationData<RolesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :params
            :roles
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :params
            :roles
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-mobile-view>
    </div>
</template>
