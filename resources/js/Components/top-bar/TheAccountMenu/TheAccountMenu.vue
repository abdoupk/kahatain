<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

const AccountMenuItems = defineAsyncComponent(() => import('@/Components/top-bar/TheAccountMenu/AccountMenuItems.vue'))

const BaseMenu = defineAsyncComponent(() => import('@/Components/Base/headless/Menu/BaseMenu.vue'))

const BaseMenuButton = defineAsyncComponent(() => import('@/Components/Base/headless/Menu/BaseMenuButton.vue'))

const TheAvatar = defineAsyncComponent(() => import('@/Components/Global/TheAvatar.vue'))

const authName = usePage().props.auth.user?.first_name + ' ' + usePage().props.auth.user?.last_name
</script>

<template>
    <base-menu>
        <base-menu-button class="image-fit zoom-in intro-x block h-8 w-8 overflow-hidden rounded-full shadow-lg">
            <the-avatar :gender="$page.props.auth.user?.gender" :name="authName"></the-avatar>
        </base-menu-button>

        <account-menu-items></account-menu-items>
    </base-menu>
</template>
