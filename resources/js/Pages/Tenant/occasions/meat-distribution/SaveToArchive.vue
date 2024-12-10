<script lang="ts" setup>
import { IndexParams } from '@/types/types'

import { useMeatDistributionStore } from '@/stores/meat-distribution'
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import MeatDistributionTypeSelector from '@/Pages/Tenant/occasions/meat-distribution/MeatDistributionTypeSelector.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BasePopover from '@/Components/Base/headless/Popover/BasePopover.vue'
import BasePopoverButton from '@/Components/Base/headless/Popover/BasePopoverButton.vue'
import BasePopoverPanel from '@/Components/Base/headless/Popover/BasePopoverPanel.vue'
import TheWarningModal from '@/Components/Global/TheWarningModal.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { getDataForIndexPages } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    params: IndexParams
}>()

const meatDistributionStore = useMeatDistributionStore()

const loading = ref(false)

const showWarningModalStatus = ref(false)

const form = useForm(
    'post',
    route('tenant.occasions.meat-distribution.save-to-archive'),
    meatDistributionStore.meatDistribution
)

const handleSave = () => {
    form.submit({
        onStart: () => {
            loading.value = true
        },
        onSuccess: () => {
            getDataForIndexPages(route('tenant.occasions.meat-distribution.index'), props.params, {
                onSuccess: () => {
                    form.reset()

                    meatDistributionStore.$reset()
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
</script>

<template>
    <div class="me-2">
        <base-popover v-slot="{ close }" class="inline-block">
            <base-popover-button :as="BaseButton" variant="primary">
                {{ $t('save') }}

                <svg-loader class="ms-2 h-4 w-4" name="icon-chevron-down"></svg-loader>
            </base-popover-button>

            <base-popover-panel placement="bottom-start">
                <form @submit.prevent="showWarningModalStatus = true">
                    <div class="!w-[450px] p-2">
                        <div class="w-full">
                            <base-form-label class="!mb-0">
                                {{ $t('meat_type') }}
                            </base-form-label>

                            <meat-distribution-type-selector
                                :value="{
                                    id: form.meat_type,
                                    name: $t(`the_${form.meat_type}`)
                                }"
                                class="!mt-0"
                                @update:value="(value) => (form.meat_type = value.id)"
                            ></meat-distribution-type-selector>
                        </div>

                        <div class="mt-6 grid grid-cols-12 gap-4">
                            <div class="col-span-12 grid grid-cols-12">
                                <div class="col-span-4">
                                    <div class="text-start text-sm rtl:!font-semibold">
                                        {{ $t('zakat_selected_families') }}
                                    </div>
                                </div>

                                <div class="col-span-8">
                                    {{ meatDistributionStore.meatDistribution.families.length }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center">
                            <base-button class="ms-auto w-32" type="button" variant="secondary" @click="close()">
                                {{ $t('cancel') }}
                            </base-button>

                            <base-button
                                :disabled="loading || meatDistributionStore.meatDistribution.meat_type === ''"
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
            $t('exports.archive.warnings.meat_distribution', {
                count: form.families.length,
                meatType: $t(`the_${form.meat_type}`)
            })
        }}
    </the-warning-modal>
</template>
