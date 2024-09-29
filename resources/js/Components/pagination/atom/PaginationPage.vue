<script lang="ts" setup>
import { computedEager } from '@vueuse/core'

import BasePaginationLink from '@/Components/Base/pagination/BasePaginationLink.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

const { page = null, current = 0 } = defineProps<{
    page: number | null
    current: number
}>()

const emit = defineEmits(['update'])

const isActive = computedEager(() => {
    return page === current
})

function clickHandler() {
    emit('update', page)
}
</script>

<template>
    <base-pagination-link v-if="page === null">
        <svg-loader class="h-5 w-5 p-1" name="icon-pagination-dots"></svg-loader>
    </base-pagination-link>
    <!-- TODO: Translate Label   -->
    <base-pagination-link v-else :active="isActive" :aria-label="`Go to page ${page}`" @click="clickHandler">
        {{ page }}
    </base-pagination-link>
</template>
