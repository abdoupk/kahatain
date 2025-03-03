<script lang="ts" setup>
import { useCommitteesStore } from '@/stores/committees'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, ref } from 'vue'

import { $t, $tc } from '@/utils/i18n'

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseFormTextArea = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormTextArea.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineProps<{
    open: boolean
}>()

// Get the committees store
const committeesStore = useCommitteesStore()

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return committeesStore.committee.id
        ? $t('successfully_updated')
        : $t('successfully_created', { attribute: $t('the_committee') })
})

const form = computed(() => {
    if (committeesStore.committee.id) {
        return useForm('put', route('tenant.committees.update', committeesStore.committee.id), {
            ...committeesStore.committee
        })
    }

    return useForm('post', route('tenant.committees.store'), { ...committeesStore.committee })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.committees.index'),
            {},
            {
                only: ['committees'],
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

// Compute the slideover title based on the committee id
const modalTitle = computed(() => {
    return committeesStore.committee.id
        ? $t('modal_update_title', {
              attribute: $t('the_committee')
          })
        : $tc('add new', 0, { attribute: $t('committee') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the committee id
const modalType = computed(() => {
    return committeesStore.committee.id ? 'update' : 'create'
})
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :modal-type="modalType"
        :open
        :title="modalTitle"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-12">
                <base-form-label htmlFor="name">
                    {{ $t('validation.attributes.name') }}
                </base-form-label>

                <base-form-input
                    id="name"
                    ref="firstInputRef"
                    v-model="form.name"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.name') })"
                    type="text"
                    @change="form.validate('name')"
                />

                <div v-if="form.errors?.name" class="mt-2">
                    <base-input-error :message="form.errors.name"></base-input-error>
                </div>
            </div>
            <!-- End: Name-->

            <!-- Begin: Name-->
            <div class="col-span-12">
                <base-form-label htmlFor="description">
                    {{ $t('validation.attributes.description') }}
                </base-form-label>

                <base-form-text-area
                    id="description"
                    v-model="form.description"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.description') })"
                    rows="5"
                    @change="form.validate('description')"
                />

                <div v-if="form.errors?.description" class="mt-2">
                    <base-input-error :message="form.errors.description"></base-input-error>
                </div>
            </div>
            <!-- End: Name-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
