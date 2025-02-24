<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { useForm } from 'laravel-precognition-vue'
import print from 'print-js'
import { computed, defineAsyncComponent, onUnmounted, ref } from 'vue'

import CalculationForm from '@/Pages/Tenant/occasions/ramadan-basket/settings/CalculationForm.vue'
import RamadanBasketItemsForm from '@/Pages/Tenant/occasions/ramadan-basket/settings/RamadanBasketItemsForm.vue'

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

// Get the sponsorships store
const sponsorshipsStore = useSponsorshipsStore()

const tabIndex = ref(0)

const form = computed(() => {
    if (tabIndex.value === 0) {
        return useForm('patch', route('tenant.occasions.ramadan-basket.update-settings'), {
            ...sponsorshipsStore.ramadan_sponsorship
        })
    }

    return useForm('patch', route('tenant.occasions.ramadan-basket.update-ramadan-basket-items'), {
        items: sponsorshipsStore.ramadan_basket.data,
        deleted_items: sponsorshipsStore.ramadan_basket?.deleted_items
    })
})

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const emit = defineEmits(['close'])

const handleSuccess = () => {
    sponsorshipsStore.ramadan_sponsorship = form.value.data()

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

const firstInputRef = ref<HTMLElement>()

const handleTabChange = (index) => {
    tabIndex.value = index
}

const printStarting = ref<boolean>(false)

const printPdf = () => {
    print({
        printable: formatUrl(route('tenant.occasions.ramadan-basket.export-monthly-basket-items.pdf')),
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
        :title="$t('settings')"
        modal-type="update"
        size="xl"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #body>
            <base-tab-group @change="handleTabChange">
                <base-tab-list class="flex" variant="link-tabs">
                    <base-tab>
                        <base-tab-button as="button" class="w-full" type="button">
                            {{ $t('monthly_sponsorship.settings') }}
                        </base-tab-button>
                    </base-tab>
                    <base-tab>
                        <base-tab-button as="button" class="w-full py-2" type="button"
                            >{{ $t('ramadan_basket_items') }}
                        </base-tab-button>
                    </base-tab>
                </base-tab-list>

                <base-tab-panels class="mt-5">
                    <base-tab-panel class="grid grid-cols-12 gap-4 gap-y-3">
                        <calculation-form :form></calculation-form>
                    </base-tab-panel>

                    <base-tab-panel>
                        <ramadan-basket-items-form :form></ramadan-basket-items-form>
                    </base-tab-panel>
                </base-tab-panels>
            </base-tab-group>
        </template>

        <template v-if="tabIndex === 1" #extraButtons>
            <base-button
                v-if="sponsorshipsStore.ramadan_basket.data?.length"
                class="me-2 ms-1 w-20"
                type="button"
                variant="soft-primary"
                @click.prevent="printPdf"
            >
                <spinner-button-loader :show="printStarting"></spinner-button-loader>

                {{ $t('print') }}
            </base-button>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="$t('successfully_updated')"></success-notification>
</template>
