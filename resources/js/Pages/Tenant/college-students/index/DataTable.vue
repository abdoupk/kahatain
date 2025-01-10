<script lang="ts" setup>
import TheDesktopView from './TheDesktopView.vue'
import TheMobileView from './TheMobileView.vue'

defineProps<{
    orphans: unknown
    params: unknown
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <the-desktop-view :orphans :params @sort="emit('sort', $event)"></the-desktop-view>

        <the-mobile-view
            :orphans
            :params
            @show-edit-modal="emit('showEditModal', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
        ></the-mobile-view>
    </div>
</template>
