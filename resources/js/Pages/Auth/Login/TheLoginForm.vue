<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseFormCheckInput from '@/Components/Base/form/form-check/BaseFormCheckInput.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

import { $t } from '@/utils/i18n'

const form = useForm({
    email: '',
    password: '',
    remember: false
})

const submit = () => {
    // eslint-disable-next-line no-undef
    form.post(route('tenant.login'), {
        onFinish: () => {
            form.reset('password')
        }
    })
}
</script>

<template>
    <!-- BEGIN: Login Form -->
    <form class="my-10 flex h-screen py-5 xl:my-0 xl:h-auto xl:py-0" @submit.prevent="submit">
        <div
            class="mx-auto my-auto w-full rounded-md bg-white px-5 py-8 shadow-md dark:bg-darkmode-600 sm:w-3/4 sm:px-8 lg:w-2/4 xl:ms-20 xl:w-auto xl:bg-transparent xl:p-0 xl:shadow-none"
        >
            <h2 class="intro-x text-center text-2xl font-bold xl:text-start xl:text-3xl">
                {{ $t('auth.Sign in') }}
            </h2>
            <div class="intro-x mt-2 text-center text-slate-400 xl:hidden">
                {{ $t('auth.hints.small') }}
            </div>

            <div class="intro-x mt-8">
                <base-form-input
                    v-model="form.email"
                    :placeholder="$t('validation.attributes.email')"
                    autofocus
                    class="intro-x block min-w-full px-4 py-3 xl:min-w-[350px]"
                    type="text"
                />

                <base-input-error :message="form.errors.email" class="mt-2"></base-input-error>

                <base-form-input
                    v-model="form.password"
                    :placeholder="$t('validation.attributes.password')"
                    class="intro-x mt-4 block min-w-full px-4 py-3 xl:min-w-[350px]"
                    type="password"
                />
                <base-input-error :message="form.errors.password" class="mt-2"></base-input-error>
            </div>

            <div class="intro-x mt-4 flex text-xs text-slate-600 dark:text-slate-500 sm:text-sm">
                <div class="me-auto flex items-center">
                    <base-form-check-input id="remember-me" class="me-2 border" type="checkbox" />
                    <label class="cursor-pointer select-none" for="remember-me">
                        {{ $t('Remember me') }}
                    </label>
                </div>
            </div>

            <div class="intro-x mt-5 text-center xl:mt-8 xl:text-start">
                <base-button class="w-full px-4 py-3 align-top xl:me-3 xl:w-32" variant="primary">
                    <spinner-button-loader :show="form.processing" class="me-1"></spinner-button-loader>

                    {{ $t('auth.Login') }}
                </base-button>
            </div>
        </div>
    </form>
    <!-- END: Login Form -->
</template>
