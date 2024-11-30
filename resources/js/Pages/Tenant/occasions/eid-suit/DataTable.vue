<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import TheDesktopView from '@/Pages/Tenant/occasions/eid-suit/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/eid-suit/TheMobileView.vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import FamilyAddressSelector from '@/Components/Global/TheAddressField/TheFamilyAddressSelector.vue'

import { getDataForIndexPages } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
}>()

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

const setLocation = (location: { lat: number; lng: number }) => {
    form.setData({
        ...form.data(),
        ...{
            [selectedOrphan.value.shop_type + '_shop_location']: location
        }
    })

    submit()
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
        onSuccess() {
            getDataForIndexPages(route('tenant.occasions.eid-suit.index'), props.params, {
                preserveScroll: true,
                preserveState: true,
                only: ['orphans'],
                onSuccess: () => {
                    showSuccessNotification.value = true

                    nextTick(() => {
                        showSuccessNotification.value = false

                        setTimeout(() => {
                            showMapModalStatus.value = false
                        })
                    })
                }
            })
        }
    })
}

const showSuccessNotification = ref(false)

const handleSaveAddress = async () => {
    await submit()
}

const handleCloseLocationModal = () => {
    getDataForIndexPages(route('tenant.occasions.eid-suit.index'), props.params, {
        preserveScroll: true,
        preserveState: true,
        only: ['orphans'],
        onSuccess: () => {
            showSuccessNotification.value = true
        }
    })
}
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :orphans
            :params
            @showLocationAddressModal="handleShowLocationAddressModal"
            @showSuccessNotification="showSuccessNotification = true"
            @sort="$emit('sort', $event)"
        ></the-desktop-view>

        <the-mobile-view :orphans :params></the-mobile-view>
    </div>

    <family-address-selector
        :location="selectedOrphan?.location"
        :open="showMapModalStatus"
        :title="$t('select_location')"
        @close="handleCloseLocationModal"
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
                @blur.prevent="handleSaveAddress"
            ></base-form-input>
        </div>
    </family-address-selector>

    <success-notification :open="showSuccessNotification" :title="$t('successfully_updated')"></success-notification>
</template>
