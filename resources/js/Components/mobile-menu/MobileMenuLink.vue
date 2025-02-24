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
        :class="
            twMerge(['flex h-[50px] items-center text-white', level == 'first' && 'px-6', level != 'first' && 'px-4'])
        "
        :href="menu.subMenu ? '#' : menu.url"
        @click.prevent="linkTo(menu, $event)"
    >
        <div>
            <!-- TODO: fix width and height  -->
            <svg-loader :name="menu.icon"></svg-loader>
        </div>
        <div class="ms-3 flex w-full items-center">
            {{ menu.title }}
            <div
                v-if="menu.subMenu"
                :class="
                    twMerge(['ms-auto transition duration-100 ease-in', menu.activeDropdown && 'rotate-180 transform'])
                "
            >
                <svg-loader class="h-5 w-5" name="icon-chevron-down"></svg-loader>
            </div>
        </div>
    </a>
</template>
