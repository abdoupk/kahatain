<script lang="ts" setup>
import type { IFormattedMenu, ILocation } from '@/types/types'

import { useMenuStore } from '@/stores/menu'
import { usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { twMerge } from 'tailwind-merge'
import { computed, onMounted, ref, watch } from 'vue'

import TheTopBar from '@/Layouts/enigma/TheTopBar.vue'
import MenuDivider from '@/Layouts/enigma/side-menu/MenuDivider.vue'
import SimpleMenuLink from '@/Layouts/enigma/simple-menu/SimpleMenuLink.vue'
import { enter, leave, nestedMenu } from '@/Layouts/menu'

import MobileMenuLoader from '@/Components/Global/MobileMenuLoader.vue'
import TheMobileMenu from '@/Components/mobile-menu/TheMobileMenu.vue'

import { toRaw } from '@/utils/helper'

const _route = { routeName: '' } as ILocation

const formattedMenu = ref<Array<IFormattedMenu | 'divider'>>([])

const menuStore = useMenuStore()

const simpleMenu = computed(() => nestedMenu(menuStore.menu as Array<IFormattedMenu | 'divider'>, _route))

const { width } = useWindowSize()

watch(
    computed(() => usePage().url),
    () => {
        delete _route.forceActiveMenu

        formattedMenu.value = toRaw(simpleMenu.value)
    }
)

onMounted(() => {
    formattedMenu.value = toRaw(simpleMenu.value)
})
</script>

<template>
    <suspense suspensible>
        <div
            :class="
                twMerge([
                    'enigma px-5 py-5 sm:px-8 md:px-0 md:py-0',
                    'before:fixed before:inset-0 before:z-[-1] before:bg-gradient-to-b before:from-theme-1 before:to-theme-2 before:content-[\'\'] dark:before:from-darkmode-800 dark:before:to-darkmode-800 md:bg-slate-200 md:before:bg-none md:dark:bg-darkmode-800'
                ])
            "
        >
            <suspense v-if="width < 768">
                <the-mobile-menu></the-mobile-menu>

                <template #fallback>
                    <mobile-menu-loader></mobile-menu-loader>
                </template>
            </suspense>
            <the-top-bar></the-top-bar>

            <div class="flex overflow-hidden">
                <nav
                    class="side-nav side-nav--simple z-50 -mt-4 hidden w-[100px] overflow-x-hidden px-5 pb-16 pt-32 md:block"
                >
                    <ul>
                        <template v-for="(menu, menuKey) in formattedMenu">
                            <li v-if="menu === 'divider'" :key="`enigma_simple__menu_divider__${menu + menuKey}`">
                                <menu-divider class="my-6"></menu-divider>
                            </li>

                            <li v-else :key="`enigma_simple__menu_${menu.title}__${menuKey}`">
                                <simple-menu-link
                                    :class="!menu.active ? `animate-delay-${(menuKey + 1) * 10}` : ''"
                                    :menu="menu"
                                    level="first"
                                ></simple-menu-link>

                                <transition @enter="enter" @leave="leave">
                                    <ul
                                        v-if="menu.subMenu && menu.activeDropdown"
                                        :class="menu.subMenu && menu.activeDropdown ? 'side-menu__sub-open' : ''"
                                    >
                                        <li
                                            v-for="(subMenu, subMenuKey) in menu.subMenu"
                                            :key="`enigma_simple__menu_${subMenu.title}__${subMenuKey}`"
                                        >
                                            <simple-menu-link
                                                :class="!subMenu.active ? `animate-delay-${(subMenuKey + 1) * 10}` : ''"
                                                :menu="subMenu"
                                                level="second"
                                            ></simple-menu-link>

                                            <!-- BEGIN: Third Child -->
                                            <transition @enter="enter" @leave="leave">
                                                <ul
                                                    v-if="subMenu.subMenu && subMenu.activeDropdown"
                                                    :class="
                                                        subMenu.subMenu && subMenu.activeDropdown
                                                            ? 'side-menu__sub-open'
                                                            : ''
                                                    "
                                                >
                                                    <li
                                                        v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu"
                                                        :key="`enigma_simple__menu_${lastSubMenu.title}__${lastSubMenuKey}`"
                                                    >
                                                        <simple-menu-link
                                                            :class="
                                                                !lastSubMenu.active
                                                                    ? `animate-delay-${(lastSubMenuKey + 1) * 10}`
                                                                    : ''
                                                            "
                                                            :menu="lastSubMenu"
                                                            level="third"
                                                        ></simple-menu-link>
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
                    :class="
                        twMerge([
                            'relative mt-5 min-h-screen min-w-0 max-w-full flex-1 rounded-[30px] bg-slate-100 px-4 pb-10 dark:bg-darkmode-700 md:mt-1 md:max-w-none md:rounded-none md:px-[22px] md:pt-20',
                            'before:block before:h-px before:w-full before:content-[\'\']'
                        ])
                    "
                >
                    <slot></slot>
                </div>
            </div>
        </div>
    </suspense>
</template>

<style lang="postcss" scoped>
@import '/resources/css/themes/enigma/side-nav.css';
</style>
