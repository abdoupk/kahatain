<script lang="ts" setup>
import type { IFormattedMenu, ILocation } from '@/types/types'

import { useMenuStore } from '@/stores/menu'
import { usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { computed, onMounted, ref, watch } from 'vue'

import TheTopBar from '@/Layouts/icewall/TheTopBar.vue'
import MenuDivider from '@/Layouts/icewall/side-menu/MenuDivider.vue'
import SideMenuLink from '@/Layouts/icewall/side-menu/SideMenuLink.vue'
import { enter, leave, nestedMenu } from '@/Layouts/menu'

import MobileMenuLoader from '@/Components/Global/MobileMenuLoader.vue'
import TheMobileMenu from '@/Components/mobile-menu/TheMobileMenu.vue'

import { toRaw } from '@/utils/helper'

const formattedMenu = ref<Array<IFormattedMenu | 'divider'>>([])

const menuStore = useMenuStore()

const _route = { routeName: '' } as ILocation

const sideMenu = computed(() => nestedMenu(menuStore.menu as Array<IFormattedMenu | 'divider'>, _route))

const { width } = useWindowSize()

watch(
    computed(() => usePage().url),
    () => {
        delete _route.forceActiveMenu

        formattedMenu.value = toRaw(sideMenu.value)
    }
)

onMounted(() => {
    formattedMenu.value = toRaw(sideMenu.value)
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

            <div
                class="wrapper relative before:absolute before:inset-x-0 before:z-[-1] before:mx-auto before:-mt-4 before:h-full before:w-[95%] before:translate-y-[35px] before:rounded-[1.3rem] before:bg-white/10 before:opacity-0 before:content-[''] before:dark:bg-darkmode-400/50"
            >
                <div
                    class="wrapper-box -mt-[7px] flex translate-y-[35px] rounded-[1.3rem] bg-gradient-to-b from-theme-1 to-theme-2 before:absolute before:inset-0 before:z-[-1] before:block before:rounded-[1.3rem] before:bg-black/[0.15] dark:from-darkmode-400 dark:to-darkmode-400 md:mt-0"
                >
                    <nav class="side-nav hidden w-[100px] overflow-x-hidden px-5 pb-16 pt-8 md:block xl:w-[250px]">
                        <ul>
                            <template v-for="(menu, menuKey) in formattedMenu">
                                <li v-if="menu === 'divider'" :key="`icewall_side_menu__divider${menu + menuKey}`">
                                    <menu-divider class="my-6"></menu-divider>
                                </li>

                                <li v-else :key="`icewall_side__menu__${menu.title}__${menuKey}`">
                                    <side-menu-link
                                        :class="!menu.active ? `animate-delay-${(menuKey + 1) * 10}` : ''"
                                        :menu="menu"
                                        level="first"
                                    ></side-menu-link>

                                    <transition @enter="enter" @leave="leave">
                                        <ul
                                            v-if="menu.subMenu && menu.activeDropdown"
                                            :class="{ 'side-menu__sub-open': menu.subMenu && menu.activeDropdown }"
                                        >
                                            <li
                                                v-for="(subMenu, subMenuKey) in menu.subMenu"
                                                :key="`icewall_side__menu__${subMenu.title}__${subMenuKey}`"
                                            >
                                                <side-menu-link
                                                    :class="
                                                        !subMenu.active ? `animate-delay-${(subMenuKey + 1) * 10}` : ''
                                                    "
                                                    :menu="subMenu"
                                                    level="second"
                                                ></side-menu-link>

                                                <!-- BEGIN: Third Child -->
                                                <transition @enter="enter" @leave="leave">
                                                    <ul
                                                        v-if="subMenu.subMenu && subMenu.activeDropdown"
                                                        :class="{
                                                            'side-menu__sub-open':
                                                                subMenu.subMenu && subMenu.activeDropdown
                                                        }"
                                                    >
                                                        <li
                                                            v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu"
                                                            :key="`icewall_side__menu__${lastSubMenu.title}__${lastSubMenuKey}`"
                                                        >
                                                            <side-menu-link
                                                                :class="
                                                                    !lastSubMenu.active
                                                                        ? `animate-delay-${(lastSubMenuKey + 1) * 10}`
                                                                        : ''
                                                                "
                                                                :menu="lastSubMenu"
                                                                level="third"
                                                            ></side-menu-link>
                                                        </li>
                                                    </ul>
                                                </transition>
                                            </li>
                                        </ul>
                                    </transition>
                                </li>
                            </template>
                        </ul>
                    </nav>

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
@import '/resources/css/themes/icewall/side-nav.css';
</style>
