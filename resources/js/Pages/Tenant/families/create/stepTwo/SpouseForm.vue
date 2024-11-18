<script lang="ts" setup>
import type { CreateFamilyForm } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{ form: Form<CreateFamilyForm> }>()

const createFamilyStore = useCreateFamilyStore()

const _deathCertificateFile = props.form?.spouse?.death_certificate_file

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
                v-model="createFamilyStore.family.spouse.first_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.first_name')
                    })
                "
                autofocus
                type="text"
                @change="form?.validate('spouse.first_name')"
            ></base-form-input>

            <base-form-input-error :form field_name="spouse.first_name"></base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="last_name">
                {{ $t('validation.attributes.last_name') }}
            </base-form-label>

            <base-form-input
                id="last_name"
                v-model="createFamilyStore.family.spouse.last_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.last_name')
                    })
                "
                type="text"
                @change="form?.validate('spouse.last_name')"
            ></base-form-input>

            <base-form-input-error :form field_name="spouse.last_name"></base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="birth_date">
                {{ $t('validation.attributes.sponsor.birth_date') }}
            </base-form-label>

            <base-v-calendar v-model:date="createFamilyStore.family.spouse.birth_date"></base-v-calendar>

            <base-form-input-error :form field_name="spouse.birth_date"></base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="death_date">
                {{ $t('validation.attributes.spouse.death_date') }}
            </base-form-label>

            <base-v-calendar
                v-model:date="createFamilyStore.family.spouse.death_date"
                :placeholder="
                    $t('auth.placeholders.fill', { attribute: $t('validation.attributes.spouse.death_date') })
                "
            ></base-v-calendar>

            <base-form-input-error :form field_name="spouse.death_date"></base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="function">
                {{ $t('validation.attributes.spouse.function') }}
            </base-form-label>

            <base-form-input
                id="function"
                v-model="createFamilyStore.family.spouse.function"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.function')
                    })
                "
                type="text"
                @change="form?.validate('spouse.function')"
            ></base-form-input>

            <base-form-input-error :form field_name="spouse.function"></base-form-input-error>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="income">
                {{ $t('validation.attributes.spouse.income') }}
            </base-form-label>

            <base-form-input
                id="income"
                v-model="createFamilyStore.family.spouse.income"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.income')
                    })
                "
                type="text"
                @change="form?.validate('spouse.income')"
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error :form field_name="spouse.income"></base-form-input-error>
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
                @update:files="createFamilyStore.family.spouse.death_certificate_file = $event[0]"
            ></base-file-pond>
        </div>
    </div>
</template>
