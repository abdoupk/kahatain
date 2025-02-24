<script lang="ts" setup>
import { useBenefactorsStore } from '@/stores/benefactors'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, ref } from 'vue'

import { $t, $tc } from '@/utils/i18n'

const TheSponsorshipsTable = defineAsyncComponent(() => import('@/Pages/Tenant/benefactors/TheSponsorshipsTable.vue'))

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

const TheAddressField = defineAsyncComponent(() => import('@/Components/Global/TheAddressField/TheAddressField.vue'))

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
        <template #description>
            <!-- Begin: First Name-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="first_name">
                    {{ $t('validation.attributes.first_name') }}
                </base-form-label>

                <base-form-input
                    id="first_name"
                    ref="firstInputRef"
                    v-model="form.first_name"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.first_name') })"
                    type="text"
                    @change="form.validate('first_name')"
                />

                <div v-if="form.errors?.first_name" class="mt-2">
                    <base-input-error :message="form.errors.first_name"></base-input-error>
                </div>
            </div>
            <!-- End: First Name-->

            <!-- Begin: Last Name-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="last_name">
                    {{ $t('validation.attributes.last_name') }}
                </base-form-label>

                <base-form-input
                    id="last_name"
                    v-model="form.last_name"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.last_name') })"
                    type="text"
                    @change="form.validate('last_name')"
                />

                <div v-if="form.errors?.last_name" class="mt-2">
                    <base-input-error :message="form.errors.last_name"></base-input-error>
                </div>
            </div>
            <!-- End: Last Name-->

            <!-- Begin: Phone-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="phone">
                    {{ $t('validation.attributes.phone_number') }}
                </base-form-label>

                <base-form-input
                    id="phone"
                    v-model="form.phone"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.phone_number') })"
                    type="text"
                    @change="form.validate('phone')"
                />

                <div v-if="form.errors?.phone" class="mt-2">
                    <base-input-error :message="form.errors.phone"></base-input-error>
                </div>
            </div>
            <!-- End: Phone-->

            <!-- Begin: address-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="address">
                    {{ $t('validation.attributes.address') }}
                </base-form-label>

                <the-address-field
                    id="address"
                    v-model:address="form.address"
                    v-model:location="form.location"
                    :select_location_label="$t('hints.select_member_location')"
                    @update:address="form.validate('address')"
                ></the-address-field>

                <div v-if="form.errors?.address" class="mt-2">
                    <base-input-error :message="form.errors.address"></base-input-error>
                </div>
            </div>
            <!-- End: address-->

            <!-- Begin: Sponsorships-->
            <the-sponsorships-table
                v-if="form.id"
                :sponsorships="form.sponsorships"
                editable
                @delete-sponsorship="form.sponsorships.splice($event, 1)"
            />
            <!-- End: Sponsorships-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
