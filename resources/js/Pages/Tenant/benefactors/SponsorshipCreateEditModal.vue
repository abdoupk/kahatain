<script lang="ts" setup>
import { useBenefactorsStore } from '@/stores/benefactors'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAddressField from '@/Components/Global/TheAddressField/TheAddressField.vue'

import { $t, $tc } from '@/utils/i18n'

defineProps<{
    open: boolean
}>()

// Get the benefactors store
const benefactorsStore = useBenefactorsStore()

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return benefactorsStore.benefactor.id
        ? $t('successfully_updated')
        : $t('successfully_created', { attribute: $t('the_benefactor') })
})

const form = computed(() => {
    if (benefactorsStore.benefactor.id) {
        return useForm('put', route('tenant.benefactors.update', benefactorsStore.benefactor.id), {
            ...benefactorsStore.benefactor
        })
    }

    return useForm('post', route('tenant.benefactors.store'), { ...benefactorsStore.benefactor })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.benefactors.index'),
            {},
            {
                only: ['benefactors'],
                preserveState: true
            }
        )
    }, 200)

    emit('close')
}

// Function to handle form submission
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

// Compute the slideover title based on the benefactor id
const modalTitle = computed(() => {
    return benefactorsStore.benefactor.id
        ? $t('modal_update_title', {
              attribute: $t('the_benefactor')
          })
        : $tc('add new', 1, { attribute: $t('benefactor') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the benefactor id
const modalType = computed(() => {
    return benefactorsStore.benefactor.id ? 'update' : 'create'
})
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :modal-type="modalType"
        :open
        :title="modalTitle"
        size="lg"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description> hello </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
