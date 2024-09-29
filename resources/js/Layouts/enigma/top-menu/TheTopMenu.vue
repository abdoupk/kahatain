<script lang="ts" setup>
import type { IFormattedMenu, ILocation, IMenu } from '@/types/types'

import { useMenuStore } from '@/stores/menu'
import { usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { computed, onMounted, ref, watch } from 'vue'

import TheTopBar from '@/Layouts/enigma/TheTopBar.vue'
import TopMenuLink from '@/Layouts/enigma/top-menu/TopMenuLink.vue'
import { nestedMenu } from '@/Layouts/menu'

import MobileMenuLoader from '@/Components/Global/MobileMenuLoader.vue'
import TheMobileMenu from '@/Components/mobile-menu/TheMobileMenu.vue'

import { toRaw } from '@/utils/helper'

const formattedMenu = ref<Array<IFormattedMenu | 'divider'>>([])

const menuStore = useMenuStore()

const _route = { routeName: '' } as ILocation

const topMenu = computed(() => nestedMenu(menuStore.menu as IMenu[], _route))

const { width } = useWindowSize()

watch(
    computed(() => usePage().url),
    () => {
        delete _route.forceActiveMenu

        formattedMenu.value = toRaw(topMenu.value)
    }
)

onMounted(() => {
    formattedMenu.value = toRaw(topMenu.value)
})
</script>

<template>
    <suspense suspensible>
        <div
            class="enigma px-5 py-5 before:fixed before:inset-0 before:z-[-1] before:bg-gradient-to-b before:from-theme-1 before:to-theme-2 before:content-[''] dark:before:from-darkmode-800 dark:before:to-darkmode-800 sm:px-8 md:bg-slate-200 md:px-0 md:py-0 md:before:bg-none md:dark:bg-darkmode-800"
        >
            <suspense v-if="width < 768">
                <the-mobile-menu></the-mobile-menu>

                <template #fallback>
                    <mobile-menu-loader></mobile-menu-loader>
                </template>
            </suspense>
            <the-top-bar></the-top-bar>

            <nav class="top-nav relative z-50 -mt-4 hidden pt-32 opacity-0 md:block">
                <ul class="flex flex-wrap px-6 xl:px-[50px]">
                    <template v-for="(menu, menuKey) in formattedMenu" :key="`enigma_side__menu_${menu + menuKey}`">
                        <li
                            v-if="menu !== 'divider'"
                            :class="
                                !menu.active
                                    ? '[&:hover>a]:bg-slate-100 [&:hover>a]:before:absolute [&:hover>a]:before:inset-0 [&:hover>a]:before:z-[-1] [&:hover>a]:before:block [&:hover>a]:before:rounded-full [&:hover>a]:before:border-b-[3px] [&:hover>a]:before:border-solid [&:hover>a]:before:border-black/[0.08] [&:hover>a]:before:content-[\'\'] [&:hover>a]:dark:bg-transparent [&:hover>a]:before:dark:bg-darkmode-700 [&:hover>a]:xl:before:rounded-xl'
                                    : ''
                            "
                            class="relative [&:hover>a>div:nth-child(2)>svg]:rotate-180 [&:hover>ul]:block"
                        >
                            <top-menu-link
                                :class="!menu.active ? `animate-delay-${(menuKey + 1) * 10}` : ''"
                                :menu="menu"
                                level="first"
                            ></top-menu-link>

                            <ul
                                v-if="menu.subMenu"
                                :class="{ 'top-menu__sub-open': menu.subMenu && menu.activeDropdown }"
                            >
                                <li
                                    v-for="(subMenu, subMenuKey) in menu.subMenu"
                                    :key="`enigma_top__menu_divider_${subMenu.title + subMenuKey}`"
                                    class="relative px-5 ltr:[&:hover>a>div:nth-child(2)>svg]:-rotate-90 rtl:[&:hover>a>div:nth-child(2)>svg]:rotate-90 [&:hover>ul]:block"
                                >
                                    <top-menu-link :menu="subMenu" level="second"></top-menu-link>

                                    <ul :class="{ 'top-menu__sub-open': subMenu.subMenu && subMenu.activeDropdown }">
                                        <li
                                            v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu"
                                            :key="`enigma_top__menu_${lastSubMenu.title}__${lastSubMenuKey}`"
                                            class="relative px-5 [&:hover>a>div:nth-child(2)>svg]:-rotate-90 [&:hover>ul]:block"
                                        >
                                            <top-menu-link :menu="lastSubMenu" level="third"></top-menu-link>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </template>
                </ul>
            </nav>

            <div
                class="relative mt-5 min-h-screen min-w-0 max-w-full flex-1 rounded-[30px] bg-slate-100 px-4 pb-10 before:block before:h-px before:w-full before:content-[''] dark:bg-darkmode-700 md:max-w-none md:rounded-[35px_35px_0_0] md:px-[22px]"
            >
                <slot></slot>
            </div>
        </div>
    </suspense>
</template>

<style lang="postcss" scoped>
@import '/resources/css/themes/enigma/top-nav.css';
</style>
