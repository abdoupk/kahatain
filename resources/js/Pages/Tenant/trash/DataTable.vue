<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { IndexParams, PaginationData, TrashIndexResource } from '@/types/types'

defineProps<{
    items: PaginationData<TrashIndexResource>
    params: IndexParams
}>()

const emit = defineEmits(['showDeleteModal', 'restore'])
</script>

<template>
    <div class="-mt-5 @container">
        <the-desktop-view
            :items
            :params
            @restore="emit('restore', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :items
            :params
            @restore="emit('restore', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
        ></the-mobile-view>
    </div>
</template>
