<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, ref } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const TheBenefactorSelector = defineAsyncComponent(
    () => import('@/Pages/Tenant/benefactors/create/TheBenefactorSelector.vue')
)

const TheRecipientable = defineAsyncComponent(() => import('@/Pages/Tenant/benefactors/create/TheRecipientable.vue'))

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInputError.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseFormSelect = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormSelect.vue'))

const BaseInputGroup = defineAsyncComponent(() => import('@/Components/Base/form/InputGroup/BaseInputGroup.vue'))

const BaseInputGroupText = defineAsyncComponent(
    () => import('@/Components/Base/form/InputGroup/BaseInputGroupText.vue')
)

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

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
                        v-model:benefactor="form.benefactor"
                        :benefactor="form.benefactor.id"
                        @update:selected-benefactor="(benefactor) => (form.benefactor = benefactor)"
                    ></the-benefactor-selector>
                </div>

                <base-form-input-error :form field_name="benefactor.id"></base-form-input-error>
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

                    <option v-if="form.recipientable_type === 'family'" value="grant">
                        {{ $t('sponsorship_type.grant') }}
                    </option>

                    <option v-if="form.recipientable_type === 'family'" value="monthly_basket">
                        {{ $t('sponsorship_type.monthly_basket') }}
                    </option>

                    <option v-if="form.recipientable_type === 'orphan'" value="social_sponsorship">
                        {{ $t('sponsorship_type.social_sponsorship') }}
                    </option>

                    <option v-if="form.recipientable_type === 'orphan'" value="educational_sponsorship">
                        {{ $t('sponsorship_type.educational_sponsorship') }}
                    </option>
                </base-form-select>

                <base-form-input-error :form field_name="sponsorship_type"></base-form-input-error>
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

                <base-form-input-error :form field_name="amount"></base-form-input-error>
            </div>
            <!--End: The amount-->

            <!--Begin: Until-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="until">
                    {{ $t('validation.attributes.until') }}
                </base-form-label>

                <base-v-calendar id="until" v-model:date="form.until"></base-v-calendar>

                <base-form-input-error :form field_name="until"></base-form-input-error>
            </div>
            <!--End: Until-->

            <!--Begin: The shop-->
            <div
                v-if="form.sponsorship_type === 'monthly_basket'"
                class="col-span-12 mt-8 grid grid-cols-12 gap-4 gap-y-3"
            >
                <h3 class="col-span-12 text-base rtl:font-semibold">
                    {{ $t('shop_information') }}
                </h3>

                <!-- Begin: The shopKeeper name-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label for="shopKeeper_name">
                        {{ $t('shop.name') }}
                    </base-form-label>

                    <base-form-input
                        id="shopKeeper_name"
                        v-model="form.shop.name"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('shop.name') })"
                        type="text"
                        @change="form?.validate('shop.name')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="shop.name">
                        <div
                            v-if="form?.invalid('shop.name')"
                            class="mt-2 text-danger"
                            data-test="error_start_date_message"
                        >
                            {{ form.errors['shop.name'] }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- End: The shopKeeper name-->

                <!-- Begin: The shopKeeper phone number-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label for="shopKeeper_phone_number">
                        {{ $t('shop.phone') }}
                    </base-form-label>

                    <base-form-input
                        id="shopKeeper_phone_number"
                        v-model="form.shop.phone"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('shop.phone') })"
                        maxlength="10"
                        type="text"
                        @change="form?.validate('shop.phone')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-form-input-error :form field_name="shop.phone"></base-form-input-error>
                </div>
                <!-- End: The shopKeeper phone number-->

                <!-- Begin: The shopKeeper address-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label for="shopKeeper_address">
                        {{ $t('shop.address') }}
                    </base-form-label>

                    <base-form-input
                        id="shopKeeper_address"
                        v-model="form.shop.address"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('shop.address') })"
                        type="text"
                        @change="form?.validate('shop.address')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="shop.address"></base-form-input-error>
                </div>
                <!-- End: The shopKeeper address-->
            </div>
            <!--End: The shop-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
