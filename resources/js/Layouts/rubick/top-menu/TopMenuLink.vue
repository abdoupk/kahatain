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
                'relative flex h-[55px] items-center rounded-full text-white xl:rounded-b-none xl:rounded-t-[1rem]',

                $page.url === menu.url && '!cursor-default',

                level == 'first' && 'me-1 px-5',
                level != 'first' && 'me-0 px-0',
                level == 'first' && menu.active && 'z-10 bg-slate-100 dark:bg-darkmode-700',
                level == 'first' &&
                    menu.active &&
                    'before:bg-menu-corner dark:before:bg-menu-corner-dark before:absolute before:bottom-0 before:start-0 before:-ms-[20px] before:hidden before:h-[20px] before:w-[20px] before:rotate-90 before:scale-[1.04] before:bg-[length:100%] before:content-[\'\'] before:xl:block',
                level == 'first' &&
                    menu.active &&
                    'after:bg-menu-corner dark:after:bg-menu-corner-dark after:absolute after:bottom-0 after:end-0 after:-me-[20px] after:hidden after:h-[20px] after:w-[20px] after:rotate-180 after:scale-[1.04] after:bg-[length:100%] after:content-[\'\'] after:xl:block',
                menu.active && 'top-menu--active',
                !menu.active &&
                    level === 'first' &&
                    'translate-y-[50px] animate-[0.4s_ease-in-out_0.3s_intro-menu] opacity-0 animate-fill-mode-forwards'
            ])
        "
        :href="menu.subMenu ? '#' : menu.url"
        class="top-menu"
        @click="linkTo(menu, $event)"
    >
        <div
            :class="
                twMerge([
                    'dark:text-slate-400',
                    level == 'first' && menu.active && 'text-primary dark:text-white',
                    !menu.active &&
                        'before:absolute before:start-0 before:top-0 before:z-[-1] before:h-full before:w-full before:rounded-full before:transition before:duration-100 before:ease-in before:content-[\'\'] xl:before:rounded-b-none xl:before:rounded-t-lg'
                ])
            "
        >
            <!-- TODO: fix width and height  -->
            <svg-loader :name="menu.icon"></svg-loader>
        </div>
        <div
            :class="
                twMerge([
                    'ms-3 flex items-center whitespace-nowrap dark:text-slate-400',
                    level == 'first' && menu.active && 'font-medium text-black dark:text-white',
                    level != 'first' && 'w-full'
                ])
            "
        >
            {{ menu.title }}

            <svg-loader
                v-if="menu.subMenu"
                :class="
                    twMerge([
                        'hidden h-4 w-4 transition duration-100 ease-in xl:block',
                        level == 'first' && 'ms-2',
                        level != 'first' && 'ms-auto'
                    ])
                "
                name="icon-chevron-down"
            ></svg-loader>
        </div>
    </a>
</template>
