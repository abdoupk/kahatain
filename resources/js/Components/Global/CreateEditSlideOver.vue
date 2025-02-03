<script lang="ts" setup>
import { useWindowSize } from '@vueuse/core'
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseSlideover = defineAsyncComponent(() => import('@/Components/Base/headless/Slideover/BaseSlideover.vue'))

const BaseSlideoverDescription = defineAsyncComponent(
    () => import('@/Components/Base/headless/Slideover/BaseSlideoverDescription.vue')
)

const BaseSlideoverFooter = defineAsyncComponent(
    () => import('@/Components/Base/headless/Slideover/BaseSlideoverFooter.vue')
)

const BaseSlideoverPanel = defineAsyncComponent(
    () => import('@/Components/Base/headless/Slideover/BaseSlideoverPanel.vue')
)

const BaseSlideoverTitle = defineAsyncComponent(
    () => import('@/Components/Base/headless/Slideover/BaseSlideoverTitle.vue')
)

const SpinnerButtonLoader = defineAsyncComponent(() => import('@/Components/Global/SpinnerButtonLoader.vue'))

const TheModalLoader = defineAsyncComponent(() => import('@/Components/Global/TheModalLoader.vue'))

defineProps<{
    open: boolean
    title: string
    loading: boolean
    slideoverType: 'create' | 'update'
    focusableInput?: HTMLElement
}>()

const { width } = useWindowSize()

const emit = defineEmits(['close', 'handleSubmit'])
</script>

<template>
    <base-slideover :initialFocus="focusableInput" :open :staticBackdrop="width < 768" @close="emit('close')">
        <base-slideover-panel class="overflow-y-auto">
            <suspense suspensible>
                <template #default>
                    <form @submit.prevent="emit('handleSubmit')">
                        <base-slideover-title>
                            <h2 class="me-auto text-base font-medium rtl:font-semibold">
                                {{ title }}
                            </h2>
                        </base-slideover-title>

                        <base-slideover-description>
                            <slot name="description"></slot>
                        </base-slideover-description>

                        <base-slideover-footer class="pb-safe-bottom flex justify-end lg:pb-0">
                            <base-button
                                class="me-1 w-20"
                                type="button"
                                variant="outline-secondary"
                                @click="emit('close')"
                            >
                                {{ $t('cancel') }}
                            </base-button>

                            <base-button :disabled="loading" class="w-20" type="submit" variant="primary">
                                <spinner-button-loader :show="loading"></spinner-button-loader>

                                {{ $t(slideoverType) }}
                            </base-button>
                        </base-slideover-footer>
                    </form>
                </template>

                <template #fallback>
                    <the-modal-loader></the-modal-loader>
                </template>
            </suspense>
        </base-slideover-panel>
    </base-slideover>
</template>
