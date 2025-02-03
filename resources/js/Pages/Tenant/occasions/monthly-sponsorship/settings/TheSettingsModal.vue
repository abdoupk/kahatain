<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { useForm } from 'laravel-precognition-vue'
import print from 'print-js'
import { computed, defineAsyncComponent, onUnmounted, ref } from 'vue'

import CalculationForm from '@/Pages/Tenant/occasions/monthly-sponsorship/settings/CalculationForm.vue'
import MonthlyBasketItemsForm from '@/Pages/Tenant/occasions/monthly-sponsorship/settings/MonthlyBasketItemsForm.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseTab from '@/Components/Base/headless/Tab/BaseTab.vue'
import BaseTabButton from '@/Components/Base/headless/Tab/BaseTabButton.vue'
import BaseTabGroup from '@/Components/Base/headless/Tab/BaseTabGroup.vue'
import BaseTabList from '@/Components/Base/headless/Tab/BaseTabList.vue'
import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

import { formatUrl } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineProps<{
    open: boolean
}>()

const sponsorshipsStore = useSponsorshipsStore()

const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = $t('successfully_updated')

const tabIndex = ref(0)

const form = computed(() => {
    if (tabIndex.value === 0) {
        return useForm('patch', route('tenant.occasions.monthly-sponsorship.update-settings'), {
            ...sponsorshipsStore.monthly_sponsorship
        })
    }

    return useForm('patch', route('tenant.occasions.monthly-sponsorship.update-monthly-basket'), {
        items: sponsorshipsStore.monthly_basket.data
    })
})

const emit = defineEmits(['close'])

const handleSuccess = () => {
    if (tabIndex.value === 0) {
        sponsorshipsStore.monthly_sponsorship = form.value.data()
    }

    emit('close')
}

const handleSubmit = async () => {
    loading.value = true

    try {
        await form.value
            .submit({
                onSuccess() {
                    showSuccessNotification.value = true
                },
                onFinish() {
                    showSuccessNotification.value = false
                }
            })
            .then(handleSuccess)
    } finally {
        loading.value = false
    }
}

const modalTitle = $t('settings')

const firstInputRef = ref<HTMLElement>()

const handleTabChange = (index) => {
    tabIndex.value = index
}

const printStarting = ref<boolean>(false)

const printPdf = () => {
    print({
        printable: formatUrl(route('tenant.occasions.monthly-sponsorship.export-monthly-basket-items.pdf')),
        type: 'pdf',
        font: 'Roboto',
        onLoadingStart: () => {
            printStarting.value = true
        },
        onLoadingEnd: () => {
            printStarting.value = false
        }
    })
}

onUnmounted(() => sponsorshipsStore.$reset())
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :open
        :title="modalTitle"
        modal-type="update"
        size="xl"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #body>
            {{}}
            <base-tab-group @change="handleTabChange">
                <base-tab-list class="flex" variant="link-tabs">
                    <base-tab>
                        <base-tab-button as="button" class="w-full" type="button">
                            {{ $t('monthly_sponsorship.settings') }}
                        </base-tab-button>
                    </base-tab>
                    <base-tab>
                        <base-tab-button as="button" class="w-full py-2" type="button"
                            >{{ $t('monthly_basket_items') }}
                        </base-tab-button>
                    </base-tab>
                </base-tab-list>

                <base-tab-panels class="mt-5">
                    <base-tab-panel class="grid grid-cols-12 gap-4 gap-y-3">
                        <calculation-form :form></calculation-form>
                    </base-tab-panel>

                    <base-tab-panel>
                        <monthly-basket-items-form :form></monthly-basket-items-form>
                    </base-tab-panel>
                </base-tab-panels>
            </base-tab-group>
        </template>

        <template v-if="tabIndex === 1" #extraButtons>
            <base-button class="me-2 ms-1 w-20" type="button" variant="soft-primary" @click.prevent="printPdf">
                <spinner-button-loader :show="printStarting"></spinner-button-loader>

                {{ $t('print') }}
            </base-button>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
