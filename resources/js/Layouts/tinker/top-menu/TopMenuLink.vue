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
                'relative me-1 flex h-[55px] items-center rounded-full px-5 text-white xl:rounded-xl',

                $page.url === menu.url && '!cursor-default',

                level == 'first' && 'mt-[3px]',
                level == 'first' && menu.active && 'bg-slate-100 dark:bg-darkmode-700 xl:bg-primary',
                level == 'first' &&
                    menu.active &&
                    'before:absolute before:inset-0 before:hidden before:rounded-xl before:border-b-[3px] before:border-solid before:border-black/10 before:bg-white/[0.08] before:content-[\'\'] before:dark:border-black/10 before:dark:bg-darkmode-700 xl:before:block',
                level !== 'first' && 'me-0 px-0',
                !menu.active &&
                    level === 'first' &&
                    'translate-y-[50px] animate-[0.4s_ease-in-out_0.3s_intro-menu] opacity-0 animate-fill-mode-forwards'
            ])
        "
        :href="menu.subMenu ? '#' : route(menu.routeName)"
        @click="linkTo(menu, $event)"
    >
        <div
            :class="
                twMerge([
                    'z-10 dark:text-slate-400',
                    level == 'first' && '-mt-[3px]',
                    level == 'first' && menu.active && 'text-primary dark:text-white xl:text-white'
                ])
            "
        >
            <!-- TODO: fix width and height  -->
            <svg-loader :name="menu.icon"></svg-loader>
        </div>
        <div
            :class="
                twMerge([
                    'z-10 ms-3 flex items-center whitespace-nowrap dark:text-slate-400',
                    level == 'first' && '-mt-[3px]',
                    level == 'first' &&
                        menu.active &&
                        'font-medium text-slate-800 dark:text-white xl:text-white rtl:font-semibold',
                    level != 'first' && 'w-full'
                ])
            "
        >
            {{ menu.title }}

            <svg-loader
                v-if="menu.subMenu"
                :class="
                    twMerge([
                        'h-4 w-4 transition duration-300 ease-in xl:block',
                        level == 'first' && 'ms-2',
                        level != 'first' && 'ms-auto'
                    ])
                "
                name="icon-chevron-down"
            ></svg-loader>
        </div>
    </a>
</template>
