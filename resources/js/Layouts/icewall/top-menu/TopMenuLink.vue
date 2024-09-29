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
                'relative me-1 flex h-[55px] items-center rounded-full px-5 text-white xl:h-[47px] xl:rounded-lg',

                level != 'first' && 'me-0 px-0',
                level == 'first' && 'mt-[3px]',
                level == 'first' && menu.active && 'bg-slate-100 dark:bg-darkmode-700 xl:bg-primary',

                level == 'first' &&
                    menu.active &&
                    'before:absolute before:inset-0 before:hidden before:rounded-lg before:border-b-[3px] before:border-solid before:border-black/10 before:bg-white/[0.08] before:content-[\'\'] before:dark:border-black/10 before:dark:bg-darkmode-700 xl:before:block',

                level == 'first' &&
                    menu.active &&
                    'after:bg-menu-active dark:after:bg-menu-active-dark after:absolute after:bottom-0 after:end-0 after:start-0 after:mx-auto after:-mb-[74px] after:hidden after:h-[80px] after:w-[20px] after:rotate-90 after:transform after:animate-[0.3s_ease-in-out_1s_active-top-menu-chevron] after:bg-cover after:bg-no-repeat after:opacity-0 after:content-[\'\'] after:animate-fill-mode-forwards xl:after:block',
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
                    'z-10 dark:text-slate-400',
                    level == 'first' && menu.active && 'text-primary dark:text-white xl:text-white',
                    level == 'first' && '-mt-[3px]'
                ])
            "
        >
            <!-- TODO: fix width and height  -->
            <svg-loader :name="menu.icon"></svg-loader>
        </div>
        <div
            :class="
                twMerge([
                    'z-10 ms-3 flex w-full items-center whitespace-nowrap dark:text-slate-400',
                    level == 'first' && menu.active && 'font-medium text-slate-800 dark:text-white xl:text-white',
                    level == 'first' && '-mt-[3px]'
                ])
            "
        >
            {{ menu.title }}

            <svg-loader
                v-if="menu.subMenu"
                :class="
                    twMerge([
                        'h-4 w-4 transform transition duration-300 ease-in xl:block',
                        level == 'first' && 'ms-2',
                        level != 'first' && 'ms-auto'
                    ])
                "
                name="icon-chevron-down"
            ></svg-loader>
        </div>
    </a>
</template>
