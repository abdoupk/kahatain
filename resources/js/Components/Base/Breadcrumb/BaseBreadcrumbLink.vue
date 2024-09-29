<script setup lang="ts">
import type { ProvideBeradcrumb } from './BaseBreadcrumb.vue'

import { useSettingsStore } from '@/stores/settings'
import { Link } from '@inertiajs/vue3'
import { type LiHTMLAttributes, computed, inject } from 'vue'

interface LinkProps extends /* @vue-ignore */ LiHTMLAttributes {
    href?: string
    active?: boolean
    index?: number
}

const { href = '', active = false, index = 0 } = defineProps<LinkProps>()

const breadcrumb = inject<ProvideBeradcrumb>('breadcrumb')

const settingsStore = useSettingsStore()

const computedClass = computed(() => [
    index > 0 && 'relative ms-5 ps-0.5',
    breadcrumb &&
        !breadcrumb.light &&
        index > 0 &&
        "before:content-[''] before:w-[14px] before:h-[14px] ltr:before:bg-bredcrumb-chevron-ltr-dark rtl:before:bg-bredcrumb-chevron-rtl-dark before:bg-[length:100%] before:-ms-[1.125rem] before:absolute before:my-auto before:inset-y-0",
    breadcrumb &&
        breadcrumb.light &&
        index > 0 &&
        "before:content-[''] before:w-[14px] before:h-[14px] ltr:before:bg-bredcrumb-chevron-ltr-light rtl:before:bg-bredcrumb-chevron-rtl-light before:bg-[length:100%] before:-ms-[1.125rem] before:absolute before:my-auto before:inset-y-0",
    index > 0 && 'dark:before:bg-bredcrumb-chevron-darkmode',
    breadcrumb && !breadcrumb.light && active && 'text-slate-800 cursor-text dark:text-slate-400',
    breadcrumb && breadcrumb.light && active && 'text-white/70',
    settingsStore.theme !== 'enigma' &&
        'ltr:before:bg-bredcrumb-chevron-ltr-dark rtl:before:bg-bredcrumb-chevron-rtl-dark dark:ltr:before:bg-bredcrumb-chevron-ltr-light dark:rtl:before:bg-bredcrumb-chevron-rtl-light'
])
</script>

<template>
    <li :class="computedClass">
        <Link :href="href" v-if="active">
            <slot></slot>
        </Link>
        <span v-else><slot></slot></span>
    </li>
</template>
