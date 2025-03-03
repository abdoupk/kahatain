<script lang="ts" setup>
import type { IFormattedMenu } from '@/types/types'

import { twMerge } from 'tailwind-merge'

import SideMenuTooltip from '@/Layouts/enigma/side-menu/SideMenuTooltip.vue'
import { linkTo } from '@/Layouts/menu'

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
                'relative mb-1 flex h-[50px] items-center rounded-xl ps-5 text-slate-600 dark:text-slate-300',

                $page.url === menu.url && '!cursor-default',

                !menu.active && level != 'first' && 'text-slate-600 dark:text-slate-400',
                menu.active && level == 'first' && 'bg-slate-100 dark:bg-transparent',

                menu.active &&
                    level == 'first' &&
                    'before:absolute before:inset-0 before:block before:rounded-xl before:border-b-[3px] before:border-solid before:border-black/[0.08] before:content-[\'\'] before:dark:border-black/[0.08] before:dark:bg-darkmode-700',

                menu.active &&
                    level == 'first' &&
                    'after:bg-menu-active after:dark:bg-menu-active-dark after:absolute after:bottom-0 after:end-0 after:top-0 after:my-auto after:me-[-27px] after:h-[80px] after:w-[20px] after:bg-cover after:bg-no-repeat after:content-[\'\']',

                !menu.active &&
                    !menu.activeDropdown &&
                    level == 'first' &&
                    'hover:bg-slate-100 hover:before:absolute hover:before:inset-0 hover:before:z-[-1] hover:before:block hover:before:rounded-xl hover:before:border-b-[3px] hover:before:border-solid hover:before:border-black/[0.08] hover:before:content-[\'\'] hover:dark:bg-transparent hover:before:dark:bg-darkmode-700',

                // Animation

                menu.active &&
                    level == 'first' &&
                    'after:-me-[47px] after:animate-[0.4s_ease-in-out_0.1s_active-side-menu-chevron] after:opacity-0 after:animate-fill-mode-forwards',
                menu.active && 'side-menu--active',

                !menu.active &&
                    'translate-x-[50px] animate-[0.4s_ease-in-out_0.1s_intro-menu] opacity-0 animate-fill-mode-forwards'
            ])
        "
        :content="menu.title"
        :href="menu.subMenu ? 'javascript:' : menu.url"
        class="side-menu"
        tag="a"
        @click.prevent="linkTo(menu, $event)"
    >
        <div
            :class="
                twMerge([
                    menu.active && level == 'first' && 'z-10 text-primary dark:text-slate-300',
                    menu.active && level != 'first' && 'text-slate-700 dark:text-slate-300',
                    !menu.active && 'dark:text-slate-400'
                ])
            "
        >
            <!-- TODO: fix width and height  -->
            <svg-loader :name="menu.icon" class="h-6 w-6 fill-current"></svg-loader>
        </div>
        <div
            :class="
                twMerge([
                    'ms-3 hidden w-full items-center xl:flex',
                    menu.active &&
                        level == 'first' &&
                        'z-10 font-medium text-primary dark:text-slate-300 rtl:font-semibold',
                    menu.active &&
                        level != 'first' &&
                        'font-medium text-slate-700 dark:text-slate-300 rtl:font-semibold',
                    !menu.active && 'dark:text-slate-400'
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
