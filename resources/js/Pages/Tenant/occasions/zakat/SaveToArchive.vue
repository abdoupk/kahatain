<script lang="ts" setup>
import { IndexParams } from '@/types/types'

import { useZakatStore } from '@/stores/zakat'
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import ZakatSelector from '@/Pages/Tenant/occasions/zakat/ZakatSelector.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BasePopover from '@/Components/Base/headless/Popover/BasePopover.vue'
import BasePopoverButton from '@/Components/Base/headless/Popover/BasePopoverButton.vue'
import BasePopoverPanel from '@/Components/Base/headless/Popover/BasePopoverPanel.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'
import TheWarningModal from '@/Components/Global/TheWarningModal.vue'

import { formatCurrency, getDataForIndexPages } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    params: IndexParams
}>()

const zakatStore = useZakatStore()

const loading = ref(false)

const showWarningModalStatus = ref(false)

const form = useForm('post', route('tenant.occasions.zakat.save-to-archive'), zakatStore.zakat)

const handleSave = () => {
    form.submit({
        onStart: () => {
            loading.value = true
        },
        onSuccess: () => {
            getDataForIndexPages(route('tenant.occasions.zakat.index'), props.params, {
                onSuccess: () => {
                    form.reset()

                    zakatStore.$reset()
                },
                onFinish: () => {
                    loading.value = false

                    nextTick(() => {
                        showWarningModalStatus.value = false
                    })
                },
                preserveScroll: true,
                preserveState: true,
                only: ['families']
            })
        }
    })
}

const handleSelectZakat = ($event) => {
    form.zakat_id = $event.id

    form.amount = $event.amount

    form.validate('zakat_id')
}
</script>

<template>
    <div class="me-2 text-center">
        <base-popover v-slot="{ close }" class="inline-block">
            <base-popover-button :as="BaseButton" variant="primary">
                {{ $t('save') }}

                <svg-loader class="ms-2 h-4 w-4" name="icon-chevron-down"></svg-loader>
            </base-popover-button>

            <base-popover-panel placement="bottom-start">
                <form @submit.prevent="showWarningModalStatus = true">
                    <div class="!w-[450px] p-2">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <div class="text-start text-sm rtl:!font-semibold">zakat</div>

                                <zakat-selector @update:value="handleSelectZakat"></zakat-selector>
                            </div>

                            <div class="col-span-6">
                                <div class="text-start text-sm rtl:!font-semibold">
                                    {{ $t('validation.attributes.address') }}
                                </div>

                                <base-form-input
                                    class="mt-2 flex-1"
                                    placeholder="example@gmail.com"
                                    type="text"
                                    @update:model-value="form.name = $event"
                                ></base-form-input>
                            </div>
                        </div>

                        <div class="">{{ formatCurrency(form.amount) }}</div>
                        <div class="">{{ zakatStore.zakat.families.length }}</div>
                        <div class="">{{ form.amount / zakatStore.zakat.families.length }}</div>

                        <div class="">
                            <base-form-text-area
                                v-model="form.note"
                                :placeholder="$t('validation.attributes.notes')"
                                rows="4"
                            ></base-form-text-area>
                        </div>

                        <div class="mt-3 flex items-center">
                            <base-button class="ms-auto w-32" type="button" variant="secondary" @click="close()">
                                {{ $t('cancel') }}
                            </base-button>

                            <base-button :disabled="loading" class="ms-2 w-32" type="submit" variant="primary">
                                {{ $t('save') }}
                            </base-button>
                        </div>
                    </div>
                </form>
            </base-popover-panel>
        </base-popover>
    </div>

    <the-warning-modal
        :on-progress="loading"
        :open="showWarningModalStatus"
        @accept="handleSave"
        @close="showWarningModalStatus = false"
    >
        {{ $t('exports.archive.warnings.zakat') }}
    </the-warning-modal>
</template>
