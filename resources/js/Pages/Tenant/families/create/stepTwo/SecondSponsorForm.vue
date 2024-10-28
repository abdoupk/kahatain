<script lang="ts" setup>
import type { CreateFamilyForm } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ form: Form<CreateFamilyForm> }>()

const firstName = defineModel('first_name')

const lastName = defineModel('last_name')

const phone = defineModel('phone')

const degreeOfKinship = defineModel('degree_of_kinship')

const income = defineModel('income')

const address = defineModel('address')

const withFamily = defineModel('withFamily')
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="first_name">
                {{ $t('validation.attributes.first_name') }}
            </base-form-label>

            <base-form-input
                id="first_name"
                v-model="firstName"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.first_name')
                    })
                "
                autofocus
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'second_sponsor.first_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'second_sponsor.first_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_first_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['second_sponsor.first_name']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="last_name">
                {{ $t('validation.attributes.last_name') }}
            </base-form-label>

            <base-form-input
                id="last_name"
                v-model="lastName"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.last_name')
                    })
                "
                autofocus
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'second_sponsor.last_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'second_sponsor.last_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_last_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['second_sponsor.last_name']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="degree_of_kinship">
                {{ $t('validation.attributes.degree_of_kinship') }}
            </base-form-label>

            <base-form-input
                id="degree_of_kinship"
                v-model="degreeOfKinship"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.degree_of_kinship')
                    })
                "
                autofocus
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'second_sponsor.degree_of_kinship'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'second_sponsor.degree_of_kinship'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_degree_of_kinship_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['second_sponsor.degree_of_kinship']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="phone">
                {{ $t('validation.attributes.phone') }}
            </base-form-label>

            <base-form-input
                id="phone"
                v-model="phone"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.phone')
                    })
                "
                autofocus
                maxlength="10"
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'second_sponsor.phone_number'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'second_sponsor.phone_number'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_phone_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['second_sponsor.phone_number']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="address">
                {{ $t('validation.attributes.address') }}
            </base-form-label>

            <base-form-input
                id="address"
                v-model="address"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.address')
                    })
                "
                autofocus
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'second_sponsor.address'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'second_sponsor.address'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_address_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['second_sponsor.address']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="income">
                {{ $t('validation.attributes.income') }}
            </base-form-label>

            <base-form-input
                id="income"
                v-model="income"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.income')
                    })
                "
                autofocus
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'second_sponsor.income'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'second_sponsor.income'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_income_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['second_sponsor.income']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-switch>
                <base-form-switch-input id="with_family" type="checkbox" v-model="withFamily"></base-form-switch-input>
                <base-form-switch-label htmlFor="with_family">
                    {{ $t('housing.label.with_family') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>
</template>
