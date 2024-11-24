<script lang="ts" setup>
import type { SVGType } from '@/types/types'

import { inject } from 'vue'

import SvgLoader from '@/Components/Global/SvgLoader.vue'

interface FamilyDetailView {
    view: string
    updateView: (viewName: string) => void
}

defineProps<{
    icon: SVGType
    viewName: string
}>()

const { view, updateView } = inject('familyDetailView') as FamilyDetailView
</script>

<template>
    <a
        :class="view === viewName ? 'text-primary rtl:font-bold' : 'font-medium'"
        class="mt-5 flex items-center"
        href="javascript:void(0)"
        @click="updateView(viewName)"
    >
        <svg-loader :name="icon" class="me-2 h-5 w-5"></svg-loader>
        {{ $t(viewName) }}
    </a>
</template>
