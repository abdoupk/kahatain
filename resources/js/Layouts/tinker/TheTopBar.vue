<script lang="ts" setup>
import TheAccountMenu from '@/Components/top-bar/TheAccountMenu/TheAccountMenu.vue'
import TheBreadcrumb from '@/Components/top-bar/TheBreadcrumb.vue'
import TheNotification from '@/Components/top-bar/notifications/TheNotification.vue'
import TheSearch from '@/Components/top-bar/search/TheSearch.vue'
</script>

<template>
    <div class="relative z-[51] flex h-[67px] items-center border-b border-slate-200">
        <the-breadcrumb></the-breadcrumb>

        <the-search></the-search>

        <the-notification></the-notification>

        <the-account-menu></the-account-menu>
    </div>
</template>
