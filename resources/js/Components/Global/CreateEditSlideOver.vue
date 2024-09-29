<script lang="ts" setup>
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseSlideover from '@/Components/Base/headless/Slideover/BaseSlideover.vue'
import BaseSlideoverDescription from '@/Components/Base/headless/Slideover/BaseSlideoverDescription.vue'
import BaseSlideoverFooter from '@/Components/Base/headless/Slideover/BaseSlideoverFooter.vue'
import BaseSlideoverPanel from '@/Components/Base/headless/Slideover/BaseSlideoverPanel.vue'
import BaseSlideoverTitle from '@/Components/Base/headless/Slideover/BaseSlideoverTitle.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    open: boolean
    title: string
    loading: boolean
    slideoverType: 'create' | 'update'
    focusableInput?: HTMLElement
}>()

const emit = defineEmits(['close', 'handleSubmit'])
</script>

<template>
    <base-slideover :initialFocus="focusableInput" :open @close="emit('close')">
        <base-slideover-panel class="overflow-y-auto">
            <a class="absolute end-auto start-0 top-0 -ms-12 mt-4" href="#" @click="emit('close')">
                <svg-loader class="h-8 w-8 fill-slate-400" name="icon-x-mark"></svg-loader>
            </a>

            <form @submit.prevent="emit('handleSubmit')">
                <base-slideover-title>
                    <h2 class="me-auto text-base font-medium rtl:font-semibold">
                        {{ title }}
                    </h2>
                </base-slideover-title>

                <base-slideover-description>
                    <slot name="description"></slot>
                </base-slideover-description>

                <base-slideover-footer class="flex justify-end">
                    <base-button class="me-1 w-20" type="button" variant="outline-secondary" @click="emit('close')">
                        {{ $t('cancel') }}
                    </base-button>

                    <base-button :disabled="loading" class="w-20" type="submit" variant="primary">
                        <spinner-button-loader :show="loading"></spinner-button-loader>

                        {{ $t(slideoverType) }}
                    </base-button>
                </base-slideover-footer>
            </form>
        </base-slideover-panel>
    </base-slideover>
</template>
