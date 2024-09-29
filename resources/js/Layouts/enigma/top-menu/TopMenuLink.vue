<script lang="ts" setup>
import type { IFormattedMenu } from '@/types/types'

import { twMerge } from 'tailwind-merge'

import { linkTo } from '@/Layouts/menu'

import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    level: 'first' | 'second' | 'third'
    menu: IFormattedMenu
}>()
</script>

<template>
    <a
        v-if="!menu.ignore"
        :class="
            twMerge([
                'relative me-1 flex h-[55px] items-center rounded-full px-5 text-slate-600 xl:rounded-xl',

                level === 'first' && 'mt-[3px]',
                level == 'first' && menu.active && 'bg-slate-100 text-primary dark:bg-darkmode-700',

                level == 'first' &&
                    menu.active &&
                    'before:absolute before:inset-0 before:hidden before:rounded-xl before:border-b-[3px] before:border-solid before:border-black/[0.08] before:content-[\'\'] dark:before:border-black/[0.08] before:dark:bg-darkmode-700 xl:before:block',

                level == 'first' &&
                    menu.active &&
                    'after:bg-menu-active after:dark:bg-menu-active-dark after:absolute after:bottom-0 after:end-0 after:start-0 after:mx-auto after:hidden after:h-[80px] after:w-[20px] after:rotate-90 after:transform after:bg-cover after:bg-no-repeat after:content-[\'\'] xl:after:block',
                level !== 'first' && 'me-0 px-0',

                // Animation

                level == 'first' &&
                    menu.active &&
                    'after:-mb-[74px] after:animate-[0.3s_ease-in-out_1s_active-top-menu-chevron] after:opacity-0 after:animate-fill-mode-forwards',
                menu.active && 'top-menu--active',

                !menu.active &&
                    level === 'first' &&
                    'translate-y-[50px] animate-[0.4s_ease-in-out_0.3s_intro-menu] opacity-0 animate-fill-mode-forwards'
            ])
        "
        :href="menu.subMenu ? '#' : menu.url"
        class="top-menu"
        @click.prevent="linkTo(menu, $event)"
    >
        <div
            :class="
                twMerge([
                    'z-10 dark:text-slate-400',
                    level == 'first' && '-mt-[3px]',
                    level == 'first' && menu.active && 'text-primary dark:text-white xl:text-primary'
                ])
            "
        >
            <!-- TODO: fix width and height  -->
            <svg-loader :name="menu.icon" class="h-6 w-6"></svg-loader>
        </div>
        <div
            :class="
                twMerge([
                    'z-10 ms-3 flex items-center whitespace-nowrap dark:text-slate-400',
                    level == 'first' && '-mt-[3px]',
                    level == 'first' && menu.active && 'font-medium text-slate-800 dark:text-white xl:text-primary',
                    level != 'first' && 'w-full'
                ])
            "
        >
            {{ menu.title }}

            <svg-loader
                v-if="menu.subMenu"
                :class="
                    twMerge([
                        'hidden h-4 w-4 transition duration-300 ease-in xl:block',
                        level == 'first' && 'ms-2',
                        level != 'first' && 'ms-auto'
                    ])
                "
                name="icon-chevron-down"
            ></svg-loader>
        </div>
    </a>
</template>
