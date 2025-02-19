<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { useOrphansStore } from '@/stores/orphans'
import { usePage } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

import TheDesktopView from '@/Pages/Tenant/occasions/eid-suit/TheDesktopView.vue'
import TheMobileView from '@/Pages/Tenant/occasions/eid-suit/TheMobileView.vue'

import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['showEditModal', 'showDetailsModal'])

const showSuccessNotification = ref(false)

const handleShowSuccessNotification = () => {
    showSuccessNotification.value = true

    nextTick(() => {
        showSuccessNotification.value = false
    })
}

const orphansStore = useOrphansStore()

const notifiable = ref({})

const showWarningAlert = ref(false)

window.Echo.channel('eid-suit-infos-updated').listen('EidSuitInfosUpdatedEvent', (e) => {
    const exists = e.ids.some((item) => orphansStore.selectedOrphans.includes(item))

    if (exists && usePage().props.auth.user?.id !== e.user?.id) {
        notifiable.value = e.user

        showWarningAlert.value = true
    }
})
</script>

<template>
    <div class="@container">
        <the-desktop-view
            :notifiable
            :orphans
            :params
            :show-warning-alert
            @showSuccessNotification="handleShowSuccessNotification"
            @sort="$emit('sort', $event)"
            @show-details-modal="emit('showDetailsModal', $event)"
            @show-edit-modal="emit('showEditModal', $event)"
        ></the-desktop-view>

        <the-mobile-view
            :notifiable
            :orphans
            :params
            :show-warning-alert
            @showSuccessNotification="handleShowSuccessNotification"
        ></the-mobile-view>
    </div>

    <success-notification :open="showSuccessNotification" :title="$t('successfully_updated')"></success-notification>
</template>
