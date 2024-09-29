<script lang="ts" setup>
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { $t } from '@/utils/i18n'

const form = useForm('put', route('tenant.profile.password.update'), {
    password: '',
    password_confirmation: '',
    current_password: ''
})

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
    <div class="mt-5 border-t">
        <div class="mt-5 px-2">
            <h2 class="text-base/relaxed rtl:text-xl rtl:font-semibold">{{ $t('profile.update_password') }}</h2>

            <h2 class="mt-0.5 text-sm/4 text-slate-500">
                {{ $t('profile.update_password_hint') }}
            </h2>

            <form action="" @submit.prevent="submit">
                <div class="mt-5 grid grid-cols-12 gap-4 gap-y-3">
                    <!-- Begin: Current Password-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label htmlFor="current_password">
                            {{ $t('validation.attributes.current_password') }}
                        </base-form-label>

                        <base-form-input
                            id="current_password"
                            v-model="form.current_password"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('validation.attributes.current_password')
                                })
                            "
                            class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                            onfocus="this.removeAttribute('readonly')"
                            readonly
                            type="password"
                            @change="form.validate('current_password')"
                        />

                        <div v-if="form.errors?.current_password" class="mt-2">
                            <base-input-error :message="form.errors.current_password"></base-input-error>
                        </div>
                    </div>
                    <!-- End: Current Password-->

                    <!-- Begin: New Password-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label htmlFor="password">
                            {{ $t('validation.attributes.password') }}
                        </base-form-label>

                        <base-form-input
                            id="password"
                            v-model="form.password"
                            :placeholder="
                                $t('auth.placeholders.fill', { attribute: $t('validation.attributes.password') })
                            "
                            class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                            onfocus="this.removeAttribute('readonly')"
                            readonly
                            type="password"
                            @change="form.validate('password')"
                        />

                        <div v-if="form.errors?.password" class="mt-2">
                            <base-input-error :message="form.errors.password"></base-input-error>
                        </div>
                    </div>
                    <!-- End: New Password-->

                    <!-- Begin: Password Confirmation-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label htmlFor="password_confirmation">
                            {{ $t('validation.attributes.password_confirmation') }}
                        </base-form-label>

                        <base-form-input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('validation.attributes.password_confirmation')
                                })
                            "
                            class="[&[readonly]]:cursor-default [&[readonly]]:bg-white [&[readonly]]:dark:bg-darkmode-800"
                            onfocus="this.removeAttribute('readonly')"
                            readonly
                            type="password"
                            @change="form.validate('password_confirmation')"
                        />

                        <div v-if="form.errors?.password_confirmation" class="mt-2">
                            <base-input-error :message="form.errors.password_confirmation"></base-input-error>
                        </div>
                    </div>
                    <!-- End: Password Confirmation-->

                    <base-button
                        :disabled="form.processing"
                        class="col-span-12 !mt-2 w-20"
                        type="submit"
                        variant="primary"
                    >
                        {{ $t('save') }}

                        <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                    </base-button>
                </div>
            </form>
        </div>

        <success-notification
            :open="showSuccessNotification"
            :title="$t('successfully_updated')"
        ></success-notification>
    </div>
</template>
