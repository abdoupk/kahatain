<script lang="ts" setup>
import type { IFormattedMenu, ILocation } from '@/types/types'

import { useMenuStore } from '@/stores/menu'
import { Link, usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { computed, onMounted, ref, watch } from 'vue'

import { enter, leave, nestedMenu } from '@/Layouts/menu'
import TheTopBar from '@/Layouts/tinker/TheTopBar.vue'
import MenuDivider from '@/Layouts/tinker/side-menu/MenuDivider.vue'
import SimpleMenuLink from '@/Layouts/tinker/simple-menu/SimpleMenuLink.vue'

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
            class="tinker relative px-5 py-5 after:fixed after:inset-0 after:z-[-2] after:bg-gradient-to-b after:from-theme-1 after:to-theme-2 after:content-[''] dark:bg-transparent dark:after:from-darkmode-800 dark:after:to-darkmode-800 sm:px-8 md:bg-black/[0.15] md:px-0 md:py-0"
        >
            <suspense v-if="width < 768">
                <the-mobile-menu></the-mobile-menu>

                <template #fallback>
                    <mobile-menu-loader></mobile-menu-loader>
                </template>
            </suspense>

            <div class="mt-[4.7rem] flex overflow-hidden md:mt-0">
                <nav class="z-10 hidden overflow-x-hidden px-5 pb-16 md:block md:w-[105px] xl:w-[105px]">
                    <Link :href="route('tenant.dashboard')" class="intro-x mt-3 flex items-center ps-5 pt-4">
                        <img :alt="usePage().props.association" class="w-6" src="/images/logo.svg" />
                    </Link>

                    <menu-divider class="my-6"></menu-divider>

                    <ul>
                        <template v-for="(menu, menuKey) in formattedMenu">
                            <li v-if="menu === 'divider'" :key="`tinker_simple__menu__divider${menu + menuKey}`">
                                <menu-divider class="my-6"></menu-divider>
                            </li>

                            <li v-else :key="`tinker_simple__menu__${menu.title}__${menuKey}`">
                                <simple-menu-link
                                    :class="!menu.active ? `animate-delay-${(menuKey + 1) * 10}` : ''"
                                    :menu="menu"
                                    level="first"
                                ></simple-menu-link>

                                <transition @enter="enter" @leave="leave">
                                    <ul
                                        v-if="menu.subMenu && menu.activeDropdown"
                                        :class="{ 'side-menu__sub-open': menu.subMenu && menu.activeDropdown }"
                                    >
                                        <li
                                            v-for="(subMenu, subMenuKey) in menu.subMenu"
                                            :key="`tinker_simple__menu__${subMenu.title}__${subMenuKey}`"
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
                                                    :class="{
                                                        'side-menu__sub-open': subMenu.subMenu && subMenu.activeDropdown
                                                    }"
                                                >
                                                    <li
                                                        v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu"
                                                        :key="`tinker_simple__menu__${lastSubMenu.title}__${lastSubMenuKey}`"
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
                    class="relative min-h-screen min-w-0 max-w-full flex-1 rounded-[30px] bg-slate-100 px-4 pb-10 before:block before:h-px before:w-full before:content-[''] after:absolute after:inset-y-0 after:start-0 after:z-[-1] after:-ms-4 after:mt-8 after:w-full after:bg-white/10 after:content-[''] dark:bg-darkmode-700 after:dark:bg-darkmode-400/50 md:ms-4 md:max-w-none md:px-6 ltr:after:rounded-[40px_0px_0px_0px] ltr:md:rounded-[35px/50px_0px_0px_0px] rtl:after:rounded-[0px_40px_0px_0px] rtl:md:rounded-[35px/0px_50px_0px_0px]"
                >
                    <the-top-bar></the-top-bar>

                    <slot></slot>
                </div>
            </div>
        </div>
    </suspense>
</template>

<style lang="postcss" scoped>
@import '/resources/css/themes/tinker/side-nav.css';
</style>
