<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

import TheModalLoader from '@/Components/Global/TheModalLoader.vue'

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseDialog = defineAsyncComponent(() => import('@/Components/Base/headless/Dialog/BaseDialog.vue'))

const BaseDialogDescription = defineAsyncComponent(
    () => import('@/Components/Base/headless/Dialog/BaseDialogDescription.vue')
)

const BaseDialogFooter = defineAsyncComponent(() => import('@/Components/Base/headless/Dialog/BaseDialogFooter.vue'))

const BaseDialogPanel = defineAsyncComponent(() => import('@/Components/Base/headless/Dialog/BaseDialogPanel.vue'))

const BaseDialogTitle = defineAsyncComponent(() => import('@/Components/Base/headless/Dialog/BaseDialogTitle.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

defineProps<{
    open: boolean
    title: string
}>()

const emit = defineEmits(['close'])
</script>

<template>
    <base-dialog :open @close="emit('close')">
        <base-dialog-panel>
            <suspense suspensible>
                <template #default>
                    <div>
                        <base-dialog-title>
                            <h2 class="me-auto text-base ltr:font-medium rtl:font-semibold">
                                {{ title }}
                            </h2>

                            <span class="absolute end-0 top-0 me-3 mt-3 cursor-pointer" @click.prevent="emit('close')">
                                <svg-loader class="h-5 w-5 fill-current" name="icon-x-mark"></svg-loader>
                            </span>
                        </base-dialog-title>

                        <base-dialog-description class="grid grid-cols-12 gap-4 gap-y-3">
                            <slot name="description"></slot>
                        </base-dialog-description>

                        <base-dialog-footer class="flex justify-end">
                            <base-button
                                class="me-1 w-20"
                                type="button"
                                variant="outline-secondary"
                                @click="emit('close')"
                            >
                                {{ $t('cancel') }}
                            </base-button>
                        </base-dialog-footer>
                    </div>
                </template>

                <template #fallback>
                    <the-modal-loader></the-modal-loader>
                </template>
            </suspense>
        </base-dialog-panel>
    </base-dialog>
</template>
