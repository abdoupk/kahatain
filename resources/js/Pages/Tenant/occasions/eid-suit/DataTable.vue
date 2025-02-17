<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { useOrphansStore } from '@/stores/orphans'
import { usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import MapModal from '@/Pages/Tenant/occasions/eid-suit/MapModal.vue'
import TheDesktopView from '@/Pages/Tenant/occasions/eid-suit/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/eid-suit/TheMobileView.vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { getDataForIndexPages } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['showEditModal', 'showDetailsModal'])

const showMapModalStatus = ref(false)

const selectedOrphan = ref<{
    location: {
        lat: number
        lng: number
    }
    shopType: 'clothes' | 'shoes'
    address: string
}>({
    orphan_id: '',
    location: {
        lat: null,
        lng: null
    },
    shop_type: 'clothes',
    address: ''
})

const loading = ref(false)

const setLocation = (location: { lat: number; lng: number }) => {
    selectedOrphan.value.location = location
}

const handleShowLocationAddressModal = (data: {
    orphan_id: number
    address: string
    shop_type: 'clothes' | 'shoes'
    location: {
        lat: number
        lng: number
    }
}) => {
    showMapModalStatus.value = true

    selectedOrphan.value = data
}

const submit = async () => {
    await useForm('patch', route('tenant.occasions.eid-suit.save-infos', selectedOrphan.value.orphan_id), {
        orphan_id: selectedOrphan.value.orphan_id,
        [selectedOrphan.value.shop_type + '_shop_address']: selectedOrphan.value.address,
        [selectedOrphan.value.shop_type + '_shop_location']: selectedOrphan.value.location
    }).submit({
        onStart() {
            loading.value = true
        },
        onSuccess() {
            getDataForIndexPages(route('tenant.occasions.eid-suit.index'), props.params, {
                preserveScroll: true,
                preserveState: true,
                only: ['orphans'],
                onSuccess: () => {
                    loading.value = false

                    showSuccessNotification.value = true

                    nextTick(() => {
                        showSuccessNotification.value = false

                        setTimeout(() => {
                            showMapModalStatus.value = false
                        }, 300)
                    })
                }
            })
        }
    })
}

const showSuccessNotification = ref(false)

const handleShowSuccessNotification = () => {
    showSuccessNotification.value = true

    nextTick(() => {
        showSuccessNotification.value = false
    })
}

const orphansStore = useOrphansStore()

const notifiableUserName = ref('')

const showWarningAlert = ref(false)

window.Echo.channel('eid-suit-infos-updated').listen('EidSuitInfosUpdatedEvent', (e) => {
    const exists = e.ids.includes(orphansStore.selectedOrphan)

    if (exists && usePage().props.auth.user?.id !== e.user?.id) {
        notifiableUserName.value = e.user?.name

        showWarningAlert.value = true
    }
})
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :notifiable-user-name
            :orphans
            :params
            :show-warning-alert
            @showLocationAddressModal="handleShowLocationAddressModal"
            @showSuccessNotification="handleShowSuccessNotification"
            @sort="$emit('sort', $event)"
            @select-orphan="orphansStore.selectedOrphan = $event"
            @deselect-orphan="orphansStore.selectedOrphan = ''"
            @show-details-modal="emit('showDetailsModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :notifiable-user-name
            :orphans
            :params
            :show-warning-alert
            @showLocationAddressModal="handleShowLocationAddressModal"
            @showSuccessNotification="handleShowSuccessNotification"
            @select-orphan="orphansStore.selectedOrphan = $event"
            @deselect-orphan="orphansStore.selectedOrphan = ''"
        ></the-mobile-view>
    </div>

    <map-modal
        :handle-submit="submit"
        :loading
        :location="selectedOrphan.location"
        :open="showMapModalStatus"
        :title="$t('select_location')"
        @close="showMapModalStatus = false"
        @set-location="setLocation"
    >
        <div class="col-span-12 mb-4 sm:col-span-6">
            <base-form-label>
                {{ $t('validation.attributes.address') }}
            </base-form-label>

            <base-form-input
                id="address"
                v-model="selectedOrphan.address"
                :label="$t('address')"
                :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.address') })"
                type="text"
            ></base-form-input>
        </div>
    </map-modal>

    <success-notification :open="showSuccessNotification" :title="$t('successfully_updated')"></success-notification>
</template>
