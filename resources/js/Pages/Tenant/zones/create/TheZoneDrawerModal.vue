<script lang="ts" setup>
import { PositionType } from '@/types/types'

import { useZonesStore } from '@/stores/zones'
import { onMounted, ref } from 'vue'

import TheZonesDrawer from '@/Pages/Tenant/zones/create/TheZonesDrawer.vue'

import ShowModal from '@/Components/Global/ShowModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { isEqual } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    open: boolean
    title: string
    zone: PositionType
}>()

const emit = defineEmits(['close', 'set-zone'])

const showSuccessNotification = ref(false)

const setZone = (zone) => {
    if (isEqual(zone, props.zone)) return

    emit('set-zone', zone)

    if (zone.lat !== null && zone.lng !== null) {
        showSuccessNotification.value = true

        setTimeout(() => {
            showSuccessNotification.value = false
        }, 2000)
    }
}

const positions = ref([])

onMounted(async () => {
    positions.value = await useZonesStore().getFamiliesPositions()
})
</script>

<template>
    <show-modal :open :title size="xl" @close="emit('close')">
        <template #description>
            <div class="col-span-12 h-80 overflow-hidden rounded-md bg-slate-200">
                <the-zones-drawer
                    :families-for-map="positions"
                    :zone
                    class="h-full w-full"
                    @set-zone="setZone"
                ></the-zones-drawer>
            </div>
        </template>
    </show-modal>

    <success-notification :open="showSuccessNotification" :title="$t('address_selected')"></success-notification>
</template>
