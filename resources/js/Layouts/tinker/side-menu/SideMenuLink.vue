<script lang="ts" setup>
import type { IFormattedMenu } from '@/types/types'

import { twMerge } from 'tailwind-merge'

import { linkTo } from '@/Layouts/menu'
import SideMenuTooltip from '@/Layouts/tinker/side-menu/SideMenuTooltip.vue'

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
                'relative mb-1 flex h-[50px] items-center rounded-xl ps-5 text-white dark:text-slate-300',

                $page.url === menu.url && '!cursor-default',

                !menu.active && level != 'first' && 'text-white/70 dark:text-slate-400',
                menu.active && level == 'first' && 'bg-primary dark:bg-transparent',

                menu.active &&
                    level == 'first' &&
                    'before:absolute before:inset-0 before:block before:rounded-xl before:border-b-[3px] before:border-solid before:border-black/10 before:bg-white/[0.08] before:content-[\'\'] before:dark:border-black/10 before:dark:bg-darkmode-700',

                !menu.active &&
                    !menu.activeDropdown &&
                    level == 'first' &&
                    'hover:bg-primary/60 hover:before:absolute hover:before:inset-0 hover:before:z-[-1] hover:before:block hover:before:rounded-xl hover:before:bg-white/[0.04] hover:dark:bg-transparent hover:before:dark:bg-darkmode-700',

                !menu.active &&
                    'translate-x-[50px] animate-[0.4s_ease-in-out_0.1s_intro-menu] opacity-0 animate-fill-mode-forwards'
            ])
        "
        :content="menu.title"
        :href="menu.subMenu ? 'javascript:' : menu.url"
        tag="a"
        @click="linkTo(menu, $event)"
    >
        <div
            :class="
                twMerge([
                    menu.active && level == 'first' && 'z-10 dark:text-slate-300',
                    !menu.active && level == 'first' && 'dark:text-slate-400'
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

                    menu.active && level == 'first' && 'z-10 font-medium dark:text-slate-300 rtl:font-semibold',

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
                <svg-loader class="side-menu__sub-icon h-4 w-4" name="icon-chevron-down" />
            </div>
        </div>
    </side-menu-tooltip>
</template>
