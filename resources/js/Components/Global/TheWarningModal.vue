<script lang="ts" setup>
import { ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseDialog from '@/Components/Base/headless/Dialog/BaseDialog.vue'
import BaseDialogPanel from '@/Components/Base/headless/Dialog/BaseDialogPanel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{ open: boolean; onProgress: boolean }>()

const emit = defineEmits(['close', 'accept'])

const acceptButtonRef = ref(null)
</script>

<template>
    <base-dialog :initialFocus="acceptButtonRef" :open @close="emit('close')">
        <base-dialog-panel>
            <div class="p-5 text-center">
                <svg-loader class="mx-auto mt-3 h-16 w-16 text-warning" name="icon-circle-exclamation"></svg-loader>

                <div class="mt-5 text-3xl">{{ $t('Are you sure?') }}</div>

                <div class="mt-2 text-slate-500">
                    <slot>
                        {{ $t('Do you really want to delete this record?') }}
                    </slot>

                    <br />

                    <span class="rtl:!font-semibold">{{ $t('This process cannot be undone.') }}</span>
                </div>
            </div>

            <div class="flex justify-center px-5 pb-8 text-center">
                <base-button class="me-2 w-24" type="button" variant="outline-secondary" @click="emit('close')">
                    {{ $t('cancel') }}
                </base-button>

                <base-button
                    ref="{acceptButtonRef}"
                    :disabled="onProgress"
                    class="w-24"
                    type="button"
                    variant="warning"
                    @click="emit('accept')"
                >
                    <spinner-button-loader :show="onProgress"></spinner-button-loader>

                    {{ $t('accept') }}
                </base-button>
            </div>
        </base-dialog-panel>
    </base-dialog>
</template>
