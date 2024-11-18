<script lang="ts" setup>
import type { CreateFamilyForm } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted, ref } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{ form: Form<CreateFamilyForm> }>()

const firstName = defineModel('first_name')

const lastName = defineModel('last_name')

const birthDate = defineModel('birthDate', { default: '' })

const deathDate = defineModel('deathDate', { default: '' })

const income = defineModel('income')

const job = defineModel('job')

const deathCertificateFile = defineModel('deathCertificateFile', { default: '' })

const _deathCertificateFile = ref(props.form?.spouse?.death_certificate_file)

onMounted(() => {
    document.getElementById('first_name')?.focus()
})
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <div class="col-span-12 sm:col-span-6">
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
                        'spouse.first_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'spouse.first_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_first_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['spouse.first_name']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
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
                        'spouse.last_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'spouse.last_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_last_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['spouse.last_name']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="birth_date">
                {{ $t('validation.attributes.sponsor.birth_date') }}
            </base-form-label>

            <base-v-calendar v-model:date="birthDate"></base-v-calendar>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'spouse.birth_date'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_birth_date_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['spouse.birth_date']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="death_date">
                {{ $t('validation.attributes.spouse.death_date') }}
            </base-form-label>

            <base-v-calendar
                v-model:date="deathDate"
                :placeholder="
                    $t('auth.placeholders.fill', { attribute: $t('validation.attributes.spouse.death_date') })
                "
            ></base-v-calendar>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'spouse.death_date'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_death_date_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['spouse.death_date']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="function">
                {{ $t('validation.attributes.spouse.function') }}
            </base-form-label>

            <base-form-input
                id="function"
                v-model="job"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.function')
                    })
                "
                autofocus
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'spouse.function'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'spouse.function'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_function_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['spouse.function']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="income">
                {{ $t('validation.attributes.spouse.income') }}
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
                        'spouse.income'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'spouse.income'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_income_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['spouse.income']
                    }}
                </div>
            </base-form-input-error>
        </div>

        <div class="col-span-12 lg:col-span-6">
            <base-form-label class="mb-2" for="death_certificate_file">
                {{ $t('upload-files.labels.death_certificate') }}
            </base-form-label>

            <base-file-pond
                id="death_certificate_file"
                :allow-multiple="false"
                :labelIdle="$t('upload-files.labelIdle.spouse_death_certificate')"
                :files="_deathCertificateFile"
                :is-picture="false"
                accepted-file-types="image/jpeg, image/png, application/pdf"
                @update:files="deathCertificateFile = $event[0]"
            ></base-file-pond>
        </div>
    </div>
</template>
