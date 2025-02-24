<script lang="ts" setup>
import { router } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const BaseMenuItem = defineAsyncComponent(() => import('@/Components/Base/headless/Menu/BaseMenuItem.vue'))

const BaseMenuDivider = defineAsyncComponent(() => import('@/Components/Base/headless/Menu/BaseMenuDivider.vue'))

const BaseMenuHeader = defineAsyncComponent(() => import('@/Components/Base/headless/Menu/BaseMenuHeader.vue'))

const BaseMenuItems = defineAsyncComponent(() => import('@/Components/Base/headless/Menu/BaseMenuItems.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))
</script>

<template>
    <base-menu-items class="mt-px w-56 bg-primary text-white">
        <base-menu-header class="font-normal">
            <div class="font-medium rtl:!font-semibold">
                {{ $page.props.auth.user?.first_name + ' ' + $page.props.auth.user?.last_name }}
            </div>

            <div class="mt-0.5 text-xs text-white/70 dark:text-slate-500">
                {{ $t($page.props.auth.user.roles[0]) }}
            </div>
        </base-menu-header>

        <base-menu-divider class="bg-white/[0.08]" />

        <base-menu-item class="hover:bg-white/5" @click="router.get(route('tenant.profile.edit'))">
            <svg-loader class="me-2 h-4 w-4 fill-current" name="icon-user"></svg-loader>
            {{ $t('Profile') }}
        </base-menu-item>

        <base-menu-item class="ms-1 hover:bg-white/5" @click="router.post(route('tenant.logout'))">
            <svg-loader class="me-2 h-4 w-4 fill-current" name="icon-left-from-bracket"></svg-loader>
            {{ $t('auth.Logout') }}
        </base-menu-item>
    </base-menu-items>
</template>
