<script lang="ts" setup>
import { ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseDialog from '@/Components/Base/headless/Dialog/BaseDialog.vue'
import BaseDialogPanel from '@/Components/Base/headless/Dialog/BaseDialogPanel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{ open: boolean; deleteProgress: boolean }>()

const emit = defineEmits(['close', 'delete'])

const deleteButtonRef = ref(null)
</script>

<template>
    <base-dialog :initialFocus="deleteButtonRef" :open @close="emit('close')">
        <base-dialog-panel>
            <div class="p-5 text-center">
                <svg-loader class="mx-auto mt-3 h-16 w-16 text-danger" name="icon-circle-x-mark"></svg-loader>

                <div class="mt-5 text-3xl">{{ $t('Are you sure?') }}</div>

                <div class="mt-2 text-slate-500">
                    <slot>
                        {{ $t('Do you really want to delete this record?') }}
                        <br />

                        {{ $t('This process cannot be undone.') }}
                    </slot>
                </div>
            </div>

            <div class="flex justify-center px-5 pb-8 text-center">
                <base-button class="me-2 w-24" type="button" variant="outline-secondary" @click="emit('close')">
                    {{ $t('cancel') }}
                </base-button>

                <base-button
                    ref="{deleteButtonRef}"
                    :disabled="deleteProgress"
                    class="w-24"
                    type="button"
                    variant="danger"
                    @click="emit('delete')"
                >
                    <spinner-button-loader :show="deleteProgress"></spinner-button-loader>

                    {{ $t('delete') }}
                </base-button>
            </div>
        </base-dialog-panel>
    </base-dialog>
</template>
