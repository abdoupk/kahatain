<script lang="ts" setup>
import type { CreateFamilyForm } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ form: Form<CreateFamilyForm> }>()

const createFamilyStore = useCreateFamilyStore()

onMounted(() => {
    document.getElementById('first_name')?.focus()
})
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="first_name">
                {{ $t('validation.attributes.first_name') }}
            </base-form-label>

            <base-form-input
                id="first_name"
                v-model="createFamilyStore.family.second_sponsor.first_name"
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

            <base-form-input-error :form field_name="second_sponsor.first_name"> </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="last_name">
                {{ $t('validation.attributes.last_name') }}
            </base-form-label>

            <base-form-input
                id="last_name"
                v-model="createFamilyStore.family.second_sponsor.last_name"
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

            <base-form-input-error :form field_name="second_sponsor.last_name"> </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="degree_of_kinship">
                {{ $t('validation.attributes.degree_of_kinship') }}
            </base-form-label>

            <base-form-input
                id="degree_of_kinship"
                v-model="createFamilyStore.family.second_sponsor.degree_of_kinship"
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

            <base-form-input-error :form field_name="second_sponsor.degree_of_kinship"> </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="phone">
                {{ $t('validation.attributes.phone') }}
            </base-form-label>

            <base-form-input
                id="phone"
                v-model="createFamilyStore.family.second_sponsor.phone_number"
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

            <base-form-input-error :form field_name="second_sponsor.phone_number"> </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="address">
                {{ $t('validation.attributes.address') }}
            </base-form-label>

            <base-form-input
                id="address"
                v-model="createFamilyStore.family.second_sponsor.address"
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

            <base-form-input-error :form field_name="second_sponsor.address"> </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-label for="income">
                {{ $t('validation.attributes.income') }}
            </base-form-label>

            <base-input-group>
                <!-- @vue-ignore -->
                <base-form-input
                    id="income"
                    v-model="createFamilyStore.family.second_sponsor.income"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('validation.attributes.income')
                        })
                    "
                    type="text"
                    @change="
                        form?.validate(
                            //@ts-ignore
                            'second_sponsor.income'
                        )
                    "
                    @keydown="allowOnlyNumbersOnKeyDown"
                    maxlength="10"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>

            <base-form-input-error :form field_name="second_sponsor.income"> </base-form-input-error>
        </div>

        <div class="intro-y col-span-12 sm:col-span-6">
            <base-form-switch>
                <base-form-switch-input
                    id="with_family"
                    type="checkbox"
                    v-model="createFamilyStore.family.second_sponsor.with_family"
                ></base-form-switch-input>
                <base-form-switch-label htmlFor="with_family">
                    {{ $t('housing.label.with_family') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>
</template>
