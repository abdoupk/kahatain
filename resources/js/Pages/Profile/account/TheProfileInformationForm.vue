<script lang="ts" setup>
import type { AuthInformation } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheCompetenceSelector from '@/Components/Global/TheCompetenceSelector.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    data: AuthInformation
}>()

const form = useForm('patch', route('tenant.profile.update'), { ...props.data })

const showSuccessNotification = ref(false)

const submit = () => {
    form.submit({
        onSuccess: () => {
            showSuccessNotification.value = true

            nextTick(() => {
                showSuccessNotification.value = false
            })
        }
    })
}
</script>

<template>
    <div class="px-2">
        <h2 class="text-base/relaxed rtl:text-xl rtl:font-semibold">{{ $t('profile.profile_information') }}</h2>

        <h2 class="mt-0.5 text-sm/4 text-slate-500">{{ $t('profile.profile_information_hint') }}</h2>

        <form @submit.prevent="submit">
            <div class="mt-5 grid grid-cols-12 gap-4 gap-y-3">
                <!-- Begin: First name-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="first_name">
                        {{ $t('validation.attributes.first_name') }}
                    </base-form-label>

                    <base-form-input
                        id="first_name"
                        ref="firstInputRef"
                        v-model="form.first_name"
                        :placeholder="
                            $t('auth.placeholders.fill', { attribute: $t('validation.attributes.first_name') })
                        "
                        type="text"
                        @change="form.validate('first_name')"
                    />

                    <div v-if="form.errors?.first_name" class="mt-2">
                        <base-input-error :message="form.errors.first_name"></base-input-error>
                    </div>
                </div>
                <!-- End: First name-->

                <!-- Begin: Last name-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="last_name">
                        {{ $t('validation.attributes.last_name') }}
                    </base-form-label>

                    <base-form-input
                        id="last_name"
                        v-model="form.last_name"
                        :placeholder="
                            $t('auth.placeholders.fill', { attribute: $t('validation.attributes.last_name') })
                        "
                        type="text"
                        @change="form.validate('last_name')"
                    />

                    <div v-if="form.errors?.last_name" class="mt-2">
                        <base-input-error :message="form.errors.last_name"></base-input-error>
                    </div>
                </div>
                <!-- End: Last name-->

                <!-- Begin: Email-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="email">
                        {{ $t('validation.attributes.email') }}
                    </base-form-label>

                    <base-form-input
                        id="email"
                        v-model="form.email"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.email') })"
                        class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                        onfocus="this.removeAttribute('readonly')"
                        readonly
                        type="email"
                        @change="form.validate('email')"
                    />

                    <div v-if="form.errors?.email" class="mt-2">
                        <base-input-error :message="form.errors.email"></base-input-error>
                    </div>
                </div>
                <!-- End: Email-->

                <!-- Begin: Phone-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="phone">
                        {{ $t('validation.attributes.phone') }}
                    </base-form-label>

                    <base-form-input
                        id="phone"
                        v-model="form.phone"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.phone') })"
                        class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                        onfocus="this.removeAttribute('readonly')"
                        readonly
                        type="text"
                        @change="form.validate('phone')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    />

                    <div v-if="form.errors?.phone" class="mt-2">
                        <base-input-error :message="form.errors.phone"></base-input-error>
                    </div>
                </div>
                <!-- End: Phone-->

                <!-- Begin: gender-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="gender">
                        {{ $t('validation.attributes.gender') }}
                    </base-form-label>

                    <base-form-select
                        id="gender"
                        v-model="form.gender"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.gender') })"
                        @change="form.validate('gender')"
                    >
                        <option value="male">{{ $t('male') }}</option>
                        <option value="female">{{ $t('female') }}</option>
                    </base-form-select>

                    <div v-if="form.errors?.gender" class="mt-2">
                        <base-input-error :message="form.errors.gender"></base-input-error>
                    </div>
                </div>
                <!-- End: gender-->

                <!-- Begin: qualification-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="qualification">
                        {{ $t('validation.attributes.qualification') }}

                        <span v-if="form.competences?.length"> ({{ form.competences?.length }})</span>
                    </base-form-label>

                    <the-competence-selector v-model:competences="form.competences"></the-competence-selector>

                    <div v-if="form.errors?.qualification" class="mt-2">
                        <base-input-error :message="form.errors.qualification"></base-input-error>
                    </div>
                </div>
                <!-- End: qualification-->

                <!-- Begin: address-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="address">
                        {{ $t('validation.attributes.address') }}
                    </base-form-label>

                    <div>
                        <base-form-input
                            id="address"
                            v-model="form.address"
                            :placeholder="
                                $t('auth.placeholders.fill', { attribute: $t('validation.attributes.address') })
                            "
                            type="text"
                            @change="form.validate('address')"
                        />
                    </div>

                    <div v-if="form.errors?.address" class="mt-2">
                        <base-input-error :message="form.errors.address"></base-input-error>
                    </div>
                </div>
                <!-- End: address-->

                <base-button :disabled="form.processing" class="col-span-12 !mt-2 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>

        <success-notification
            :open="showSuccessNotification"
            :title="$t('successfully_updated')"
        ></success-notification>
    </div>
</template>
