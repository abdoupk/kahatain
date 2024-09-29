<script lang="ts" setup>
import { useSettingsStore } from '@/stores/settings'
import { defineAsyncComponent } from 'vue'

const sideMenu = defineAsyncComponent({
    loader: () => import('./side-menu/TheSideMenu.vue')
})

const simpleMenu = defineAsyncComponent({
    loader: () => import('./simple-menu/TheSimpleMenu.vue')
})

const topMenu = defineAsyncComponent({
    loader: () => import('./top-menu/TheTopMenu.vue')
})

const settingsStore = useSettingsStore()
</script>

<template>
    <suspense suspensible>
        <div>
            <component :is="simpleMenu" v-if="settingsStore.layout === 'simple_menu'">
                <slot></slot>
            </component>

            <component :is="sideMenu" v-if="settingsStore.layout === 'side_menu'">
                <slot></slot>
            </component>

            <component :is="topMenu" v-if="settingsStore.layout === 'top_menu'">
                <slot></slot>
            </component>
        </div>
    </suspense>
</template>
