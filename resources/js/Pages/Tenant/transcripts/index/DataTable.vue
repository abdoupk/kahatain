<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

import type { IndexParams, OrphansTranscriptsIndexResource, PaginationData } from '@/types/types'

import dayjs from 'dayjs'
import { computed } from 'vue'

defineProps<{
    orphans: PaginationData<OrphansTranscriptsIndexResource>
    params: IndexParams
}>()

const now = dayjs()

const shouldCreateFirstTrimesterTranscript = computed(() => {
    return true

    const isJanToAug = now.month() >= 0 && now.month() <= 7

    const isNovOrDecPrevYear = now.month() === 10 || now.month() === 11

    return isNovOrDecPrevYear || isJanToAug
})

const shouldCreateSecondTrimesterTranscript = computed(() => {
    return true

    return now.month() >= 1 && now.month() <= 7
})

const shouldCreateThirdTrimesterTranscript = computed(() => {
    return true

    return now.month() >= 4 && now.month() <= 7
})

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showCreateModal', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :orphans
            :params
            :shouldCreateFirstTrimesterTranscript
            :shouldCreateSecondTrimesterTranscript
            :shouldCreateThirdTrimesterTranscript
            @sort="emit('sort', $event)"
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-create-modal="emit('showCreateModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :orphans
            :params
            :shouldCreateFirstTrimesterTranscript
            :shouldCreateSecondTrimesterTranscript
            :shouldCreateThirdTrimesterTranscript
            @show-delete-modal="emit('showDeleteModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
            @show-create-modal="emit('showCreateModal', $event)"
        ></the-mobile-view>
    </div>
</template>
