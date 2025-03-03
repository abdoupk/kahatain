<script lang="ts" setup>
import type { IFormattedMenu } from '@/types/types'

import { twMerge } from 'tailwind-merge'

import { linkTo } from '@/Layouts/menu'
import SideMenuTooltip from '@/Layouts/rubick/side-menu/SideMenuTooltip.vue'

import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    level: 'first' | 'second' | 'third'
    menu: IFormattedMenu
}>()
</script>

<template>
    <side-menu-tooltip
        v-if="!menu.ignore"
        :class="
            twMerge([
                'relative mb-1 flex h-[50px] items-center rounded-full ps-5 text-white',

                $page.url === menu.url && '!cursor-default',

                menu.active && level != 'first' && 'dark:text-slate-300',
                !menu.active && level != 'first' && 'text-white/70 dark:text-slate-400',
                menu.active && level == 'first' && 'z-10 bg-slate-100 dark:bg-darkmode-700',

                menu.active &&
                    level == 'first' &&
                    'before:bg-menu-corner dark:before:bg-menu-corner-dark before:absolute before:end-0 before:top-0 before:-me-5 before:-mt-[30px] before:h-[30px] before:w-[30px] before:rotate-90 before:scale-[1.04] before:bg-[length:100%] before:content-[\'\']',

                menu.active &&
                    level == 'first' &&
                    'after:bg-menu-corner dark:after:bg-menu-corner-dark after:absolute after:end-0 after:top-0 after:-me-5 after:mt-[50px] after:h-[30px] after:w-[30px] after:scale-[1.04] after:bg-[length:100%] after:content-[\'\']',

                !menu.active &&
                    !menu.activeDropdown &&
                    level == 'first' &&
                    '[&>div:nth-child(1)]:hover:before:bg-white/5 [&>div:nth-child(1)]:hover:before:dark:bg-darkmode-500/70',
                menu.active && 'side-menu--active',

                !menu.active &&
                    'translate-x-[50px] animate-[0.4s_ease-in-out_0.1s_intro-menu] opacity-0 animate-fill-mode-forwards'
            ])
        "
        :content="menu.title"
        :href="menu.subMenu ? 'javascript:' : menu.url"
        class="side-menu"
        tag="a"
        @click="linkTo(menu, $event)"
    >
        <div
            :class="
                twMerge([
                    menu.active && level == 'first' && 'text-primary dark:text-slate-300',
                    !menu.active && level == 'first' && 'dark:text-slate-400',

                    menu.active &&
                        level == 'first' &&
                        'before:absolute before:end-0 before:top-0 before:z-[-1] before:-me-5 before:h-full before:w-12 before:bg-slate-100 before:content-[\'\'] before:dark:bg-darkmode-700',

                    !menu.activeDropdown &&
                        !menu.active &&
                        level == 'first' &&
                        'before:absolute before:start-0 before:top-0 before:z-[-1] before:h-full before:w-[230px] before:rounded-s-full before:transition before:duration-100 before:ease-in before:content-[\'\']'
                ])
            "
        >
            <!-- TODO: fix width and height  -->
            <svg-loader :name="menu.icon" class="h-6 w-6 fill-current stroke-1.5"></svg-loader>
        </div>
        <div
            :class="
                twMerge([
                    'ms-3 hidden w-full items-center xl:flex',
                    menu.active && level != 'first' && 'font-medium rtl:font-semibold',

                    menu.active &&
                        level == 'first' &&
                        'font-medium text-slate-800 dark:text-slate-300 rtl:font-semibold',

                    !menu.active && level == 'first' && 'dark:text-slate-400'
                ])
            "
        >
            {{ menu.title }}
            <div
                v-if="menu.subMenu"
                :class="
                    twMerge([
                        'me-5 ms-auto hidden transition duration-100 ease-in xl:block',
                        menu.activeDropdown && 'rotate-180 transform'
                    ])
                "
            >
                <svg-loader class="h-4 w-4" name="icon-chevron-down" />
            </div>
        </div>
    </side-menu-tooltip>
</template>
