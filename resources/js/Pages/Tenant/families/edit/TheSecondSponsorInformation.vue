<script lang="ts" setup>
import type { FamilyUpdateSecondSponsorFormType, SecondSponsorType } from '@/types/families'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { allowOnlyNumbersOnKeyDown, omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{ secondSponsor: SecondSponsorType }>()

const inputs = reactive<FamilyUpdateSecondSponsorFormType>(omit(props.secondSponsor, ['id',
'family_id',
'name']))

const form = useForm('put', route('tenant.families.second-sponsor-update', props.secondSponsor.family_id), inputs)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof FamilyUpdateSecondSponsorFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: Second Sponsor Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">
                {{ secondSponsor.name }}
            </h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-success/30 px-2 py-1 text-sm font-semibold text-success dark:bg-darkmode-400"
            >
                {{ $t(secondSponsor.degree_of_kinship) }}
            </div>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-4 p-5">
                <!-- BEGIN: First Name -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="first_name">
                        {{ $t('validation.attributes.first_name') }}
                    </base-form-label>

                    <base-form-input
                        id="first_name"
                        v-model="form.first_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.first_name')
                            })
                        "
                        data-test="spouse_first_name"
                        type="text"
                        @change="form?.validate('first_name')"
                    ></base-form-input>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('first_name')"
                            class="mt-2 text-danger"
                            data-test="error_first_name_message"
                        >
                            {{ form.errors.first_name }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: First Name -->

                <!-- BEGIN: Last Name -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="last_name">
                        {{ $t('validation.attributes.last_name') }}
                    </base-form-label>

                    <base-form-input
                        id="last_name"
                        v-model="form.last_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.last_name')
                            })
                        "
                        data-test="spouse_last_name"
                        type="text"
                        @change="form?.validate('last_name')"
                    ></base-form-input>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('last_name')"
                            class="mt-2 text-danger"
                            data-test="error_last_name_message"
                        >
                            {{ form.errors.last_name }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Last Name -->

                <!-- BEGIN: Degree of Kinship -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="degree_of_kinship">
                        {{ $t('validation.attributes.degree_of_kinship') }}
                    </base-form-label>

                    <base-form-input
                        id="degree_of_kinship"
                        v-model="form.degree_of_kinship"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.degree_of_kinship')
                            })
                        "
                        data-test="spouse_degree_of_kinship"
                        type="text"
                        @change="form?.validate('degree_of_kinship')"
                    ></base-form-input>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('degree_of_kinship')"
                            class="mt-2 text-danger"
                            data-test="error_degree_of_kinship_message"
                        >
                            {{ form.errors.degree_of_kinship }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Degree of Kinship -->

                <!-- BEGIN: Income -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="income">
                        {{ $t('validation.attributes.income') }}
                    </base-form-label>

                    <base-input-group>
                        <base-form-input
                            id="income"
                            v-model="form.income"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('validation.attributes.income')
                                })
                            "
                            data-test="spouse_income"
                            maxlength="10"
                            step="0.01"
                            type="number"
                            @change="form?.validate('income')"
                        ></base-form-input>

                        <base-input-group-text>
                            {{ $t('DA') }}
                        </base-input-group-text>
                    </base-input-group>

                    <base-form-input-error>
                        <div v-if="form?.invalid('income')" class="mt-2 text-danger" data-test="error_income_message">
                            {{ form.errors.income }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Income -->

                <!-- BEGIN: Address -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="address">
                        {{ $t('validation.attributes.address') }}
                    </base-form-label>

                    <base-form-input
                        id="address"
                        v-model="form.address"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.address')
                            })
                        "
                        data-test="second_sponsor_address"
                        type="text"
                        @change="form?.validate('address')"
                    ></base-form-input>

                    <base-form-input-error>
                        <div v-if="form?.invalid('address')" class="mt-2 text-danger" data-test="error_address_message">
                            {{ form.errors.address }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Address -->

                <!-- BEGIN: Phone Number -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="phone_number">
                        {{ $t('validation.attributes.sponsor.phone_number') }}
                    </base-form-label>

                    <base-form-input
                        id="phone_number"
                        v-model="form.phone_number"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.sponsor.phone_number')
                            })
                        "
                        data-test="spouse_phone_number"
                        type="text"
                        @change="form?.validate('phone_number')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('phone_number')"
                            class="mt-2 text-danger"
                            data-test="error_phone_number_message"
                        >
                            {{ form.errors.phone_number }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Phone Number -->

                <div class="col-span-12 mt-2">
                    <base-form-switch>
                        <base-form-switch-input
                            id="with_family"
                            type="checkbox"
                            v-model="form.with_family"
                        ></base-form-switch-input>
                        <base-form-switch-label htmlFor="with_family">
                            {{ $t('housing.label.with_family') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Second Sponsor Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
