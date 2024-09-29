<script lang="ts" setup>
import { useWindowSize } from '@vueuse/core'
import { defineAsyncComponent } from 'vue'

const { width } = useWindowSize()

const TheSearchMobileLayout = defineAsyncComponent(() => {
    return import('./TheSearchMobileLayout.vue')
})

const TheSearchDesktopLayout = defineAsyncComponent(() => {
    return import('./TheSearchDesktopLayout.vue')
})
</script>

<template>
    <div class="intro-x relative me-3 sm:me-6">
        <the-search-desktop-layout v-if="width >= 640"></the-search-desktop-layout>

        <the-search-mobile-layout v-else></the-search-mobile-layout>
    </div>
</template>
