<script lang="ts" setup>
import type { IFormattedMenu, ILocation, IMenu } from '@/types/types'

import { useMenuStore } from '@/stores/menu'
import { usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { computed, onMounted, ref, watch } from 'vue'

import TheTopBar from '@/Layouts/icewall/TheTopBar.vue'
import TopMenuLink from '@/Layouts/icewall/top-menu/TopMenuLink.vue'
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
            class="icewall relative px-5 py-5 after:fixed after:inset-0 after:z-[-2] after:bg-gradient-to-b after:from-theme-1 after:to-theme-2 after:content-[''] dark:after:from-darkmode-800 dark:after:to-darkmode-800 sm:px-8"
        >
            <suspense v-if="width < 768">
                <the-mobile-menu></the-mobile-menu>

                <template #fallback>
                    <mobile-menu-loader></mobile-menu-loader>
                </template>
            </suspense>

            <the-top-bar></the-top-bar>
            <nav
                class="top-nav relative z-50 -mt-2 hidden translate-y-[35px] opacity-0 md:block xl:-mt-[3px] xl:px-6 xl:pt-[12px]"
            >
                <ul class="flex flex-wrap xl:h-[50px]">
                    <template
                        v-for="(menu, menuKey) in formattedMenu"
                        :key="`icewall_top__menu__${menu.title}__${menuKey}`"
                    >
                        <li
                            v-if="menu !== 'divider'"
                            :class="
                                !menu.active
                                    ? '[&:hover>a]:bg-primary/60 [&:hover>a]:before:absolute [&:hover>a]:before:inset-0 [&:hover>a]:before:z-[-1] [&:hover>a]:before:block [&:hover>a]:before:rounded-full [&:hover>a]:before:bg-white/[0.04] [&:hover>a]:before:content-[\'\'] [&:hover>a]:dark:bg-transparent [&:hover>a]:before:dark:bg-darkmode-700 [&:hover>a]:xl:before:rounded-lg [&:hover>a]:xl:before:bg-white/10'
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
                                    :key="`icewall_top__menu__${subMenu.title}__${subMenuKey}`"
                                    class="relative px-5 ltr:[&:hover>a>div:nth-child(2)>svg]:-rotate-90 rtl:[&:hover>a>div:nth-child(2)>svg]:rotate-90 [&:hover>ul]:block"
                                >
                                    <top-menu-link :menu="subMenu" level="second"></top-menu-link>

                                    <ul :class="{ 'top-menu__sub-open': subMenu.subMenu && subMenu.activeDropdown }">
                                        <li
                                            v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu"
                                            :key="`icewall_top__menu__${lastSubMenu.title}__${lastSubMenuKey}`"
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
                class="wrapper relative before:absolute before:inset-x-0 before:z-[-1] before:mx-auto before:-mt-4 before:h-full before:w-[95%] before:translate-y-[35px] before:rounded-[1.3rem] before:bg-transparent before:opacity-0 before:content-[''] before:dark:bg-darkmode-400/50 xl:before:bg-white/10"
            >
                <div
                    class="wrapper-box -mt-[7px] flex translate-y-[35px] rounded-[1.3rem] bg-transparent before:absolute before:inset-0 before:z-[-1] before:hidden before:rounded-[1.3rem] before:bg-black/[0.15] dark:bg-transparent md:-mt-[67px] md:pt-[80px] xl:-mt-[62px] xl:bg-theme-1 xl:before:block xl:dark:bg-darkmode-400"
                >
                    <div
                        class="md:max-w-auto min-h-screen min-w-0 max-w-full flex-1 rounded-[1.3rem] bg-slate-100 px-4 pb-10 shadow-sm before:block before:h-px before:w-full before:content-[''] dark:bg-darkmode-700 md:px-[22px]"
                    >
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </suspense>
</template>

<style lang="postcss" scoped>
@import '/resources/css/themes/icewall/top-nav.css';
</style>
