<script lang="ts" setup>
import { $t } from '../../../../../utils/i18n'

import type { AcademicLevelType } from '@/types/lessons'
import type { CreateFamilyForm } from '@/types/types'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted, ref } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheSponsorTypeSelector from '@/Components/Global/TheSponsorTypeSelector.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'

defineProps<{
    form?: Form<CreateFamilyForm>
}>()

const academicLevelsStore = useAcademicLevelsStore()

const academicLevels = ref<AcademicLevelType[]>([])

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForSponsors()
})

const firstName = defineModel('first_name')

const lastName = defineModel('last_name')

const phone = defineModel('phone')

const fatherName = defineModel('father_name')

const motherName = defineModel('mother_name')

const birthCertificateNumber = defineModel('birth_certificate_number')

const academicLevel = defineModel('academic_level')

const job = defineModel('function')

const healthStatus = defineModel('health_status')

const diploma = defineModel('diploma')

// Const cardNumber = defineModel('card_number')

const ccp = defineModel('ccp')

const sponsorType = defineModel('sponsorType')

const birthDate = defineModel('birth_date', { default: '' })

const isUnemployed = defineModel('isUnemployed')
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <!-- Begin: First Name -->
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
                        'sponsor.first_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.first_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_first_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.first_name']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- END: First Name -->

        <!-- Begin: Last Name -->
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
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.last_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.last_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_last_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.last_name']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Last Name -->

        <!-- Begin: CCP -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="ccp">
                {{ $t('ccp') }}
            </base-form-label>

            <base-form-input
                id="ccp"
                v-model="ccp"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('ccp')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.ccp'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.ccp'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_ccp_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.ccp']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: CCP -->

        <!-- Begin: Branch -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="sponsor_type">
                {{ $t('filters.sponsor_type') }}
            </base-form-label>

            <div>
                <!-- @vue-ignore -->
                <the-sponsor-type-selector
                    v-model:type="sponsorType"
                    @update:type="form?.validate('sponsor.sponsor_type')"
                ></the-sponsor-type-selector>
            </div>

            <base-form-input-error>
                <!-- @vue-ignore -->
                <div
                    v-if="form?.invalid('sponsor.sponsor_type')"
                    class="mt-2 text-danger"
                    data-test="error_sponsor_type_message"
                >
                    {{
                        // @ts-ignore
                        form.errors['sponsor.sponsor_type']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Branch -->

        <!-- Begin: Birth Date -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="sponsor.birth_date">
                {{ $t('validation.attributes.sponsor.birth_date') }}
            </base-form-label>

            <base-v-calendar v-model:date="birthDate"></base-v-calendar>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.birth_date'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_start_date_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.birth_date']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Birth Date -->

        <!-- Begin: Phone Number -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="phone_number">
                {{ $t('validation.attributes.phone') }}
            </base-form-label>

            <base-form-input
                id="phone_number"
                v-model="phone"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.phone')
                    })
                "
                maxlength="10"
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.phone_number'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.phone_number'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_phone_number_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.phone_number']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Phone Number -->

        <!-- Begin: Father Name -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="father_name">
                {{ $t('validation.attributes.sponsor.father_name') }}
            </base-form-label>

            <base-form-input
                id="father_name"
                v-model="fatherName"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.father_name')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.father_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.father_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_father_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.father_name']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Father Name -->

        <!-- Begin: Mother Name -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="mother_name">
                {{ $t('validation.attributes.sponsor.mother_name') }}
            </base-form-label>

            <base-form-input
                id="mother_name"
                v-model="motherName"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.mother_name')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.mother_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.mother_name'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_mother_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.mother_name']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Mother Name -->

        <!-- Begin: Birth Certificate Number -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="birth_certificate_number">
                {{ $t('validation.attributes.sponsor.birth_certificate_number') }}
            </base-form-label>

            <base-form-input
                id="birth_certificate_number"
                v-model="birthCertificateNumber"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.birth_certificate_number')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.birth_certificate_number'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.birth_certificate_number'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_birth_certificate_number_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.birth_certificate_number']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Birth Certificate Number -->

        <!-- Begin: Academic Level -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="academic_level">
                {{ $t('validation.attributes.sponsor.academic_level') }}
            </base-form-label>

            <div>
                <!-- @vue-ignore -->
                <the-academic-level-selector
                    id="academic_level"
                    v-model:academic-level="academicLevel"
                    :academicLevels
                    @update:academic-level="form?.validate(`sponsor.academic_level_id`)"
                ></the-academic-level-selector>
            </div>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.academic_level_id'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_academic_level_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.academic_level_id']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Academic Level -->

        <!-- Begin: Function -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="function">
                {{ $t('validation.attributes.sponsor.function') }}
            </base-form-label>

            <base-form-input
                id="function"
                v-model="job"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.function')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.function'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.function'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_function_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.function']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Function -->

        <!-- Begin: Health Status -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="health_status">
                {{ $t('validation.attributes.sponsor.health_status') }}
            </base-form-label>

            <base-form-input
                id="health_status"
                v-model="healthStatus"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.health_status')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.health_status'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.health_status'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_health_status_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.health_status']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Health Status -->

        <!-- Begin: Diploma -->
        <div class="col-span-9 sm:col-span-6">
            <base-form-label for="diploma">
                {{ $t('validation.attributes.sponsor.diploma') }}
            </base-form-label>

            <base-form-input
                id="diploma"
                v-model="diploma"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.diploma')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.diploma'
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            'sponsor.diploma'
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_diploma_message"
                >
                    {{
                        //@ts-ignore
                        form.errors['sponsor.diploma']
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Diploma -->

        <!--Begin: Unemployed-->
        <div class="col-span-3 mt-6 flex items-center sm:col-span-3">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="is_unemployed"
                    v-model="isUnemployed"
                    type="checkbox"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="is_unemployed">
                    {{ $t('unemployed') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!--END: Unemployed-->

        <slot></slot>
    </div>
</template>
