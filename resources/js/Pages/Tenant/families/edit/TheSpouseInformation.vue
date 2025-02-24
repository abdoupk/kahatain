<script lang="ts" setup>
import type { FamilyUpdateSpouseFormType, SpouseType } from '@/types/families'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{ spouse: SpouseType }>()

// eslint-disable-next-line array-element-newline
const inputs = reactive<FamilyUpdateSpouseFormType>(omit(props.spouse, ['id', 'family_id', 'name', 'files']))

const form = useForm('put', route('tenant.families.spouse-update', props.spouse.id), inputs)

const deathCertificateFile = ref(props.spouse.death_certificate_file)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof FamilyUpdateSpouseFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: Spouse Information -->
    <div class="intro-y box !z-0 col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ spouse.name }}</h2>
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

                    <base-form-input-error :form field_name="first_name"></base-form-input-error>
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

                    <base-form-input-error :form field_name="last_name"></base-form-input-error>
                </div>
                <!-- END: Last Name -->

                <!-- BEGIN: Birth Date -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="birth_date">
                        {{ $t('validation.attributes.spouse.birth_date') }}
                    </base-form-label>

                    <base-v-calendar id="birth_date" v-model:date="form.birth_date"></base-v-calendar>

                    <base-form-input-error :form field_name="birth_date"></base-form-input-error>
                </div>
                <!-- END: Birth Date -->

                <!-- BEGIN: Death Date -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="death_date">
                        {{ $t('validation.attributes.spouse.death_date') }}
                    </base-form-label>

                    <base-v-calendar id="death_date" v-model:date="form.death_date"></base-v-calendar>

                    <base-form-input-error :form field_name="death_date"></base-form-input-error>
                </div>
                <!-- END: Death Date -->

                <!-- BEGIN: Function (Job) -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="function">
                        {{ $t('filters.spouse.function') }}
                    </base-form-label>

                    <base-form-input
                        id="function"
                        v-model="form.function"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('filters.spouse.function')
                            })
                        "
                        data-test="spouse_function"
                        type="text"
                        @change="form?.validate('function')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="function"></base-form-input-error>
                </div>
                <!-- END: Function (Job) -->

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

                    <base-form-input-error :form field_name="income"></base-form-input-error>
                </div>
                <!-- END: Income -->

                <!-- BEGIN: Death certificate file -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="death_certificate_file">
                        {{ $t('upload-files.labels.death_certificate') }}
                    </base-form-label>

                    <base-file-pond
                        id="death_certificate_file"
                        :allow-multiple="false"
                        :files="deathCertificateFile"
                        :is-picture="false"
                        :label-idle="$t('upload-files.labelIdle.spouse_death_certificate')"
                        accepted-file-types="image/jpeg, image/png, application/pdf"
                        @update:files="form.death_certificate_file = $event[0]"
                    ></base-file-pond>
                </div>
                <!-- END: Death certificate file -->

                <div class="col-span-12">
                    <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                        {{ $t('save') }}

                        <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                    </base-button>
                </div>
            </div>
        </form>
    </div>
    <!-- END: Spouse Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
