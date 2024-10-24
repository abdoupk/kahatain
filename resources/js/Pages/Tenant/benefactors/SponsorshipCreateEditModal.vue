<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import TheBenefactorSelector from '@/Pages/Tenant/benefactors/TheBenefactorSelector.vue'
import TheRecipientable from '@/Pages/Tenant/benefactors/TheRecipientable.vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

defineProps<{
    open: boolean
}>()

// Get the benefactors store
const sponsorship = useSponsorshipsStore()

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return sponsorship.sponsorship.id
        ? $t('successfully_updated')
        : $t('successfully_created', { attribute: $t('the_sponsorship') })
})

const form = computed(() => {
    if (sponsorship.sponsorship.id) {
        return useForm('put', route('tenant.benefactors.update', sponsorship.sponsorship.id), {
            ...sponsorship.sponsorship
        })
    }

    return useForm('post', route('tenant.monthly-sponsorship.store'), { ...sponsorship.sponsorship })
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
    return sponsorship.sponsorship.id
        ? $t('modal_update_title', {
              attribute: $t('the_sponsorship')
          })
        : $tc('add new', 0, { attribute: $t('sponsorship') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the benefactor id
const modalType = computed(() => {
    return sponsorship.sponsorship.id ? 'update' : 'create'
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
            <!--Begin: Recipient Type-->
            <div class="col-span-12">
                <the-recipientable
                    v-model:recipient-type="form.recipientable_type"
                    :error-message="form.errors.recipientable_id"
                    @update:recipient="
                        (value) => {
                            form.recipientable_id = value.id
                        }
                    "
                ></the-recipientable>
            </div>
            <!--End: Recipient Type-->

            <!--Begin: The Benefactor-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="benefactor">
                    {{ $t('the_benefactor') }}
                </base-form-label>

                <div>
                    <the-benefactor-selector
                        :benefactor="form.benefactor.id"
                        v-model:benefactor="form.benefactor"
                        @update:selected-benefactor="(benefactor) => (form.benefactor = benefactor)"
                    ></the-benefactor-selector>
                </div>

                <base-form-input-error>
                    <div
                        v-if="form?.invalid('benefactor.id')"
                        class="mt-2 text-danger"
                        data-test="error_start_date_message"
                    >
                        {{ form.errors['benefactor.id'] }}
                    </div>
                </base-form-input-error>
            </div>
            <!--Begin: The Benefactor-->

            <!--Begin: Sponsorship Type-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="sponsorship_type">
                    {{ $t('sponsorship_type') }}
                </base-form-label>

                <base-form-select
                    id="sponsorship_type"
                    v-model="form.sponsorship_type"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('sponsorship_type') })"
                    @change="form.validate('sponsorship_type')"
                >
                    <option value="">
                        {{ $t('auth.placeholders.tomselect', { attribute: $t('sponsorship_type') }) }}
                    </option>
                    <option value="ccp">{{ $t('sponsorship_type.ccp') }}</option>

                    <option value="monthly_basket">{{ $t('sponsorship_type.monthly_basket') }}</option>

                    <option value="cash">{{ $t('sponsorship_type.cash') }}</option>
                </base-form-select>

                <base-form-input-error>
                    <div
                        v-if="form?.invalid('sponsorship_type')"
                        class="mt-2 text-danger"
                        data-test="error_start_date_message"
                    >
                        {{ form.errors.sponsorship_type }}
                    </div>
                </base-form-input-error>
            </div>
            <!--End: Sponsorship Type-->

            <!--Begin: The amount-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="amount">
                    {{ $t('the_amount') }}
                </base-form-label>

                <base-input-group>
                    <!-- @vue-ignore -->
                    <base-form-input
                        id="amount"
                        v-model="form.amount"
                        :placeholder="$t('validation.attributes.the_amount')"
                        maxlength="6"
                        type="text"
                        @change="form?.validate('amount')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error>
                    <div v-if="form?.invalid('amount')" class="mt-2 text-danger" data-test="error_start_date_message">
                        {{ form.errors.amount }}
                    </div>
                </base-form-input-error>
            </div>
            <!--End: The amount-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
