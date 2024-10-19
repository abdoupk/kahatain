<script lang="ts" setup>
import { PositionType } from '@/types/types'

import { ref } from 'vue'

import ShowModal from '@/Components/Global/ShowModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheFamilyLocationSelector from '@/Components/Global/TheAddressField/TheFamilyLocationSelector.vue'

import { isEqual } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    open: boolean
    title: string
    location: PositionType
}>()

const emit = defineEmits(['close', 'set-location'])

const showSuccessNotification = ref(false)

const setLocation = (location) => {
    if (isEqual(location, props.location)) return

    emit('set-location', location)

    showSuccessNotification.value = true

    setTimeout(() => {
        showSuccessNotification.value = false
    }, 2000)
}
</script>

<template>
    <show-modal :open :title size="xl" @close="emit('close')">
        <template #description>
            <div class="col-span-12 h-80 overflow-hidden rounded-md bg-slate-200">
                <the-family-location-selector
                    :location
                    class="h-full w-full"
                    @set-location="setLocation"
                ></the-family-location-selector>
            </div>
        </template>
    </show-modal>

    <success-notification :open="showSuccessNotification" :title="$t('address_selected')"></success-notification>
</template>
