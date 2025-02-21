<script lang="ts" setup>
import { useForm } from 'laravel-precognition-vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import TheCitySelector from '@/Components/Global/CitySelector/TheCitySelector.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

import { $t } from '@/utils/i18n'

const hostname = '.' + new URL(import.meta.env.VITE_APP_URL).hostname

const form = useForm('post', '/register', {
    first_name: '',
    last_name: '',
    association: '',
    domain: '',
    email: '',
    password: '',
    password_confirmation: '',
    city_id: ''
})

const blurDomainField = (event: Event) => {
    let str = (event.target as HTMLInputElement).value

    form.domain = str.endsWith('-') ? str.slice(0, -1) + '' : str
}

const updateDomainName = (event: Event) => {
    let str = (event.target as HTMLInputElement).value

    str = str.replace(/[^a-zA-Z0-9\s-]|^[0-9]+|([a-zA-Z-])[0-9]+(?=[a-zA-Z-\s])/g, '$1')

    str = str.replace(/\s+/g, '-')

    str = str.replace(/--+|^-+/g, '-')

    str = str.replace(/(-[0-9]+)+$/g, '$1')

    form.domain = str.replace(/-(?=\d+)/g, '')
}

const submit = () => {
    form.submit({
        onSuccess(response) {
            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof typeof form.errors)
            })

            setTimeout(() => {
                window.location.href = response.data.url
            }, 200)
        }
    })
}
</script>

<template>
    <!-- BEGIN: Register Form -->
    <form class="my-10 flex h-full py-5 xl:my-0 xl:h-auto xl:py-0" @submit.prevent="submit">
        <div
            class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ms-20 xl:w-[439px] xl:bg-transparent xl:p-0 xl:shadow-none"
        >
            <h2 class="intro-x text-center text-2xl font-bold xl:text-start xl:text-3xl">
                {{ $t('the_register') }}
            </h2>
            <div class="intro-x mt-2 text-center text-slate-400 xl:hidden">
                {{ $t('auth.hints.small') }}
            </div>

            <div class="intro-x mt-8">
                <!-- BEGIN: FIRST Name Field -->
                <base-form-input
                    v-model="form.first_name"
                    :placeholder="$t('validation.attributes.first_name')"
                    autofocus
                    class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]"
                    type="text"
                />

                <base-input-error :message="form.errors.first_name" class="mt-2"></base-input-error>
                <!-- END: FIRST Name Field -->

                <!-- BEGIN: Last Name Field -->
                <base-form-input
                    v-model="form.last_name"
                    :placeholder="$t('validation.attributes.last_name')"
                    autofocus
                    class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]"
                    type="text"
                />

                <base-input-error :message="form.errors.last_name" class="mt-2"></base-input-error>
                <!-- END: Last Name Field -->

                <!-- BEGIN: Email Field -->
                <base-form-input
                    v-model="form.email"
                    :placeholder="$t('validation.attributes.email')"
                    autofocus
                    class="intro-x mt-4 block min-w-full px-4 py-3 placeholder:text-end xl:min-w-[350px]"
                    dir="auto"
                    type="text"
                />

                <base-input-error :message="form.errors.email" class="mt-2"></base-input-error>
                <!-- END: Email Field -->

                <!-- BEGIN: Password Field -->
                <base-form-input
                    v-model="form.password"
                    :placeholder="$t('validation.attributes.password')"
                    class="intro-x mt-4 block min-w-full px-4 py-3 placeholder:text-end xl:min-w-[350px]"
                    dir="auto"
                    type="password"
                />

                <base-input-error :message="form.errors.password" class="mt-2"></base-input-error>
                <!-- END: Password Field -->

                <!-- BEGIN: Password Confirmation Field -->
                <base-form-input
                    v-model="form.password_confirmation"
                    :placeholder="$t('validation.attributes.password_confirmation')"
                    class="intro-x mt-4 block min-w-full px-4 py-3 placeholder:text-end xl:min-w-[350px]"
                    dir="auto"
                    type="password"
                />

                <base-input-error :message="form.errors.password_confirmation" class="mt-2"></base-input-error>
                <!-- END: Password Confirmation Field -->

                <!-- BEGIN: Association Name Field -->
                <base-form-input
                    v-model="form.association"
                    :placeholder="$t('validation.attributes.association')"
                    autofocus
                    class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]"
                    type="text"
                />

                <base-input-error :message="form.errors.association" class="mt-2"></base-input-error>
                <!-- END: Association Name Field -->

                <!-- BEGIN: Domain Field -->
                <base-input-group class="intro-x mt-4 rtl:flex-row-reverse">
                    <base-form-input
                        id="domain"
                        v-model="form.domain"
                        class="!rounded-none !rounded-s"
                        dir="ltr"
                        placeholder="el-baraka"
                        type="text"
                        @blur="blurDomainField"
                        @input="
                            (e) => {
                                updateDomainName(e)
                                form?.validate('domain')
                            }
                        "
                    ></base-form-input>

                    <base-input-group-text class="rtl:!rounded-none rtl:!rounded-s">
                        <p dir="ltr">{{ hostname }}</p>
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error :form field_name="domain"></base-form-input-error>
                <!-- END: Domain Field -->

                <the-city-selector
                    v-model:city-id="form.city_id"
                    :error-message="form.errors.city_id"
                    city=""
                    class="intro-x !z-[60] mt-4 w-full"
                ></the-city-selector>
            </div>

            <div class="intro-x mt-5 text-center xl:mt-8 xl:text-start">
                <base-button
                    :disabled="form.processing"
                    class="w-full px-4 py-3 align-top xl:me-3 xl:w-32"
                    variant="primary"
                >
                    <spinner-button-loader :show="form.processing" class="me-1"></spinner-button-loader>

                    {{ $t('Register') }}
                </base-button>
            </div>
        </div>
    </form>
    <!-- END: Register Form -->
</template>
