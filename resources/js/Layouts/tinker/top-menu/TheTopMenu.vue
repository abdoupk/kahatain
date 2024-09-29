<script lang="ts" setup>
import type { IFormattedMenu, ILocation, IMenu } from '@/types/types'

import { useMenuStore } from '@/stores/menu'
import { Link, usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { computed, onMounted, ref, watch } from 'vue'

import { nestedMenu } from '@/Layouts/menu'
import TopMenuLink from '@/Layouts/tinker/top-menu/TopMenuLink.vue'

import MobileMenuLoader from '@/Components/Global/MobileMenuLoader.vue'
import TheMobileMenu from '@/Components/mobile-menu/TheMobileMenu.vue'
import TheAccountMenu from '@/Components/top-bar/TheAccountMenu/TheAccountMenu.vue'
import TheBreadcrumb from '@/Components/top-bar/TheBreadcrumb.vue'
import TheNotification from '@/Components/top-bar/notifications/TheNotification.vue'
import TheSearch from '@/Components/top-bar/search/TheSearch.vue'

import { isAssociationNameLatin, toRaw } from '@/utils/helper'

const formattedMenu = ref<Array<IFormattedMenu | 'divider'>>([])

const menuStore = useMenuStore()

const { width } = useWindowSize()

const _route = { routeName: '' } as ILocation

const topMenu = computed(() => nestedMenu(menuStore.menu as IMenu[], _route))

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
            class="tinker relative px-5 py-5 after:fixed after:inset-0 after:z-[-2] after:bg-gradient-to-b after:from-theme-1 after:to-theme-2 after:content-[''] dark:bg-transparent dark:after:from-darkmode-800 dark:after:to-darkmode-800 sm:px-8 md:bg-black/[0.15] md:px-0 md:py-0"
        >
            <suspense v-if="width < 768">
                <the-mobile-menu></the-mobile-menu>

                <template #fallback>
                    <mobile-menu-loader></mobile-menu-loader>
                </template>
            </suspense>

            <div
                class="relative z-[51] -mx-5 mb-10 mt-12 h-[70px] border-b border-white/[0.08] px-4 sm:-mx-8 sm:px-8 md:mx-0 md:mb-8 md:mt-0 md:px-6"
            >
                <div class="flex h-full items-center">
                    <Link :href="route('tenant.dashboard')" class="-intro-x hidden items-center md:flex">
                        <img :alt="usePage().props.association" class="w-6" src="/images/logo.svg" />
                        <span
                            :class="isAssociationNameLatin ? 'text-sm' : 'text-base'"
                            class="ms-3 max-w-40 truncate font-semibold capitalize text-white"
                        >
                            {{ $page.props.association }}
                        </span>
                    </Link>

                    <the-breadcrumb
                        class="-intro-x me-auto flex h-full border-white/[0.08] md:ms-10 md:border-s md:ps-10"
                        light
                    ></the-breadcrumb>

                    <the-search></the-search>

                    <the-notification
                        class="relative block text-white/70 outline-none before:absolute before:end-0.5 before:top-[-2px] before:h-[8px] before:w-[8px] before:rounded-full before:bg-danger before:content-[''] dark:text-slate-500"
                    ></the-notification>

                    <the-account-menu></the-account-menu>
                </div>
            </div>

            <nav class="top-nav relative z-50 -mt-[3px] hidden translate-y-[50px] opacity-0 md:block">
                <ul class="flex flex-wrap px-6 xl:px-[50px]">
                    <template v-for="(menu, menuKey) in formattedMenu">
                        <li
                            v-if="menu !== 'divider'"
                            :key="`tinker_top__menu__${menu.title}__${menuKey}`"
                            :class="
                                !menu.active &&
                                '[&:hover>a]:bg-primary/60 [&:hover>a]:before:absolute [&:hover>a]:before:inset-0 [&:hover>a]:before:z-[-1] [&:hover>a]:before:block [&:hover>a]:before:rounded-full [&:hover>a]:before:bg-white/[0.04] [&:hover>a]:before:content-[\'\'] [&:hover>a]:dark:bg-transparent [&:hover>a]:before:dark:bg-darkmode-700 [&:hover>a]:xl:before:rounded-xl'
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
                                    :key="`tinker_top__menu__${subMenu.title}__${subMenuKey}`"
                                    class="relative px-5 ltr:[&:hover>a>div:nth-child(2)>svg]:-rotate-90 rtl:[&:hover>a>div:nth-child(2)>svg]:rotate-90 [&:hover>ul]:block"
                                >
                                    <top-menu-link :menu="subMenu" level="second"></top-menu-link>

                                    <ul
                                        v-if="subMenu.subMenu"
                                        :class="{ 'top-menu__sub-open': subMenu.subMenu && subMenu.activeDropdown }"
                                    >
                                        <li
                                            v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu"
                                            :key="`tinker_top__menu__${lastSubMenu.title}__${lastSubMenuKey}`"
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
                class="relative mt-8 min-h-screen min-w-0 max-w-full flex-1 rounded-[30px] bg-slate-100 px-4 pb-10 before:block before:h-px before:w-full before:content-[''] after:absolute after:inset-y-0 after:end-0 after:start-0 after:z-[-1] after:mx-auto after:-mt-4 after:w-[97%] after:rounded-[40px_40px_0px_0px] after:bg-white/10 after:content-[''] dark:bg-darkmode-700 after:dark:bg-darkmode-400/50 md:max-w-none md:rounded-[35px_35px_0px_0px] md:px-6"
            >
                <slot></slot>
            </div>
        </div>
    </suspense>
</template>

<style lang="postcss" scoped>
@import '/resources/css/themes/tinker/top-nav.css';
</style>
