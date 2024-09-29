<script lang="ts" setup>
import { defineAsyncComponent, onMounted, ref } from 'vue'

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseSlideover = defineAsyncComponent(() => import('@/Components/Base/headless/Slideover/BaseSlideover.vue'))

const BaseSlideoverDescription = defineAsyncComponent(
    () => import('@/Components/Base/headless/Slideover/BaseSlideoverDescription.vue')
)

const BaseSlideoverPanel = defineAsyncComponent(
    () => import('@/Components/Base/headless/Slideover/BaseSlideoverPanel.vue')
)

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

const AppearanceSelector = defineAsyncComponent(() => import('@/Components/theme-switcher/AppearanceSelector.vue'))

const ColorSchemeSelector = defineAsyncComponent(() => import('@/Components/theme-switcher/ColorSchemeSelector.vue'))

const LayoutSelector = defineAsyncComponent(() => import('@/Components/theme-switcher/LayoutSelector.vue'))

const ThemeSelector = defineAsyncComponent(() => import('@/Components/theme-switcher/ThemeSelector.vue'))

const slideoverStatus = ref<boolean>(false)

const changeStatus = (value: boolean): void => {
    slideoverStatus.value = value
}

const ready = ref(false)

onMounted(() => {
    setTimeout(() => {
        ready.value = true
    }, 300)
})
</script>

<template>
    <suspense v-if="ready">
        <div>
            <base-slideover :open="slideoverStatus" class="dialog" @close="changeStatus(false)">
                <base-slideover-panel>
                    <base-button
                        as="a"
                        class="absolute inset-y-0 end-auto start-0 my-auto -ms-[60px] flex h-8 w-8 items-center justify-center rounded-full border border-white/90 bg-white/5 text-white/90 transition-all hover:rotate-180 hover:scale-105 hover:bg-white/10 focus:outline-none sm:-ms-[105px] sm:h-14 sm:w-14"
                        @click="changeStatus(false)"
                    >
                        <svg-loader
                            class="h-3 w-3 !fill-current stroke-[1] sm:h-8 sm:w-8"
                            name="icon-x-mark"
                        ></svg-loader>
                    </base-button>
                    <base-slideover-description class="p-0">
                        <div class="flex flex-col">
                            <theme-selector></theme-selector>
                            <div class="border-b border-dashed"></div>
                            <layout-selector></layout-selector>
                            <div class="border-b border-dashed"></div>
                            <color-scheme-selector></color-scheme-selector>
                            <div class="border-b border-dashed"></div>
                            <appearance-selector></appearance-selector>
                        </div>
                    </base-slideover-description>
                </base-slideover-panel>
            </base-slideover>

            <base-button
                as="div"
                class="dark:border-1 fixed bottom-0 end-0 z-50 mb-5 me-5 flex h-14 w-14 cursor-pointer items-center justify-center rounded-full border-0 bg-theme-1 text-white shadow-lg"
                @click="changeStatus(true)"
            >
                <svg-loader
                    class="h-5 w-5 animate-spin !fill-current duration-[3000]"
                    name="icon-gear-complex"
                ></svg-loader>
            </base-button>
        </div>
    </suspense>
</template>
