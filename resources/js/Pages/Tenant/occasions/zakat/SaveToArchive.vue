<script lang="ts" setup>
import { IndexParams } from '@/types/types'

import { useZakatStore } from '@/stores/zakat'
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import ZakatSelector from '@/Pages/Tenant/occasions/zakat/ZakatSelector.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BasePopover from '@/Components/Base/headless/Popover/BasePopover.vue'
import BasePopoverButton from '@/Components/Base/headless/Popover/BasePopoverButton.vue'
import BasePopoverPanel from '@/Components/Base/headless/Popover/BasePopoverPanel.vue'
import TheWarningModal from '@/Components/Global/TheWarningModal.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

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
    <div class="z-[60] me-2">
        <base-popover v-slot="{ close }" class="inline-block">
            <base-popover-button :as="BaseButton" variant="primary">
                {{ $t('save') }}

                <svg-loader class="ms-2 h-4 w-4" name="icon-chevron-down"></svg-loader>
            </base-popover-button>

            <base-popover-panel placement="bottom-start">
                <form @submit.prevent="showWarningModalStatus = true">
                    <div class="z-50 w-[280px] sm:w-[350-px] md:w-[405px]">
                        <div class="w-full">
                            <base-form-label class="!mb-0">
                                {{ $t('zakat') }}
                            </base-form-label>

                            <zakat-selector class="!mt-0" @update:value="handleSelectZakat"></zakat-selector>
                        </div>

                        <div class="mt-6 grid grid-cols-12 gap-4">
                            <div class="col-span-12 grid grid-cols-12">
                                <div class="col-span-4">
                                    <div class="text-start text-sm rtl:!font-semibold">
                                        {{ $t('the_amount') }}
                                    </div>
                                </div>

                                <div class="col-span-8">
                                    {{ formatCurrency(form.amount) }}
                                </div>
                            </div>

                            <div class="col-span-12 grid grid-cols-12">
                                <div class="col-span-4">
                                    <div class="text-start text-sm rtl:!font-semibold">
                                        {{ $t('zakat_selected_families') }}
                                    </div>
                                </div>

                                <div class="col-span-8">
                                    {{ zakatStore.zakat.families.length }}
                                </div>
                            </div>

                            <div class="col-span-12 grid grid-cols-12">
                                <div class="col-span-4">
                                    <div class="text-start text-sm rtl:!font-semibold">
                                        {{ $t('zakat_per_family') }}
                                    </div>
                                </div>

                                <div class="col-span-8">
                                    {{ formatCurrency(form.amount / zakatStore.zakat.families.length) }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center">
                            <base-button class="ms-auto w-32" type="button" variant="secondary" @click="close()">
                                {{ $t('cancel') }}
                            </base-button>

                            <base-button
                                :disabled="loading || !form.zakat_id"
                                class="ms-2 w-32"
                                type="submit"
                                variant="primary"
                            >
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
        {{
            $t('exports.archive.warnings.zakat', {
                amount: formatCurrency(form.amount / zakatStore.zakat.families.length)
            })
        }}
    </the-warning-modal>
</template>
