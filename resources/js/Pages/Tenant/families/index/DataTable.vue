<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

import TheDesktopView from '@/Pages/Tenant/families/index/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/families/index/TheMobileView.vue'

defineProps<{
    families: PaginationData<FamiliesIndexResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort', 'showDeleteModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :families
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :families
            :params
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
        ></the-mobile-view>
    </div>
</template>
