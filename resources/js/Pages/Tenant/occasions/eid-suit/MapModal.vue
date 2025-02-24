<script lang="ts" setup>
import { PositionType } from '@/types/types'

import { ref } from 'vue'

import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import TheFamilyLocationSelector from '@/Components/Global/TheAddressField/TheFamilyLocationSelector.vue'

import { isEqual } from '@/utils/helper'

const props = defineProps<{
    open: boolean
    title: string
    location: PositionType
    loading: boolean
    handleSubmit: () => void
}>()

const emit = defineEmits(['close', 'set-location'])

const showSuccessNotification = ref(false)

const setLocation = (location) => {
    if (isEqual(location, props.location)) return

    emit('set-location', location)

    if (location.lat !== null && location.lng !== null) {
        showSuccessNotification.value = true

        setTimeout(() => {
            showSuccessNotification.value = false
        }, 2000)
    }
}
</script>

<template>
    <create-edit-modal
        :loading
        :open
        :title
        modal-type="create"
        size="xl"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <slot></slot>

            <div class="col-span-12 h-80 overflow-hidden rounded-md bg-slate-200">
                <the-family-location-selector
                    :location
                    class="h-full w-full"
                    @set-location="setLocation"
                ></the-family-location-selector>
            </div>
        </template>
    </create-edit-modal>
</template>
