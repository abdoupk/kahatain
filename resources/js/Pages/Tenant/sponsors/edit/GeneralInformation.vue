<script lang="ts" setup>
import { $t } from '../../../../utils/i18n'

import type { AcademicLevelType } from '@/types/lessons'
import type { SponsorUpdateFormType } from '@/types/sponsors'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useForm } from 'laravel-precognition-vue'
import { onMounted, reactive, ref } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheSponsorTypeSelector from '@/Components/Global/TheSponsorTypeSelector.vue'

import { omit } from '@/utils/helper'

const props = defineProps<{ sponsor: SponsorUpdateFormType }>()

const emit = defineEmits(['sponsor-updated'])

// eslint-disable-next-line array-element-newline
const inputs = reactive<SponsorUpdateFormType>(
    // eslint-disable-next-line array-element-newline
    omit(props.sponsor, ['sponsorships', 'id', 'creator', 'incomes'])
)

const form = useForm('put', route('tenant.sponsors.infos-update', props.sponsor.id), inputs)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof SponsorUpdateFormType)
            })

            emit('sponsor-updated', { ...props.sponsor, ...form.data() })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}

const academicLevels = ref<AcademicLevelType[]>([])

const academicLevelsStore = useAcademicLevelsStore()

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForSponsors()
})
</script>

<template>
    <!-- BEGIN: Sponsor Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('display information') }}</h2>
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
                        data-test="sponsor_first_name"
                        type="text"
                        @change="form?.validate('first_name')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="first_name"> </base-form-input-error>
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
                        data-test="sponsor_last_name"
                        type="text"
                        @change="form?.validate('last_name')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="last_name"> </base-form-input-error>
                </div>
                <!-- END: Last Name -->

                <!-- BEGIN: BirthDate -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="birth_date">
                        {{ $t('validation.attributes.spouse.birth_date') }}
                    </base-form-label>

                    <base-v-calendar v-model:date="form.birth_date"></base-v-calendar>

                    <base-form-input-error :form field_name="birth_date"> </base-form-input-error>
                </div>
                <!-- END: BirthDate -->

                <!-- BEGIN: Father Name -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="father_name">
                        {{ $t('validation.attributes.sponsor.father_name') }}
                    </base-form-label>

                    <base-form-input
                        id="father_name"
                        v-model="form.father_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.sponsor.father_name')
                            })
                        "
                        data-test="sponsor_father_name"
                        type="text"
                        @change="form?.validate('father_name')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="father_name"> </base-form-input-error>
                </div>
                <!-- END: Father Name -->

                <!-- BEGIN: Mother Name -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="mother_name">
                        {{ $t('validation.attributes.sponsor.mother_name') }}
                    </base-form-label>

                    <base-form-input
                        id="mother_name"
                        v-model="form.mother_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.sponsor.mother_name')
                            })
                        "
                        data-test="sponsor_mother_name"
                        type="text"
                        @change="form?.validate('mother_name')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="mother_name"> </base-form-input-error>
                </div>
                <!-- END: Mother Name -->

                <!-- BEGIN: Birth Certificate number -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="birth_certificate_number">
                        {{ $t('validation.attributes.sponsor.birth_certificate_number') }}
                    </base-form-label>

                    <base-form-input
                        id="birth_certificate_number"
                        v-model="form.birth_certificate_number"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.sponsor.birth_certificate_number')
                            })
                        "
                        data-test="sponsor_birth_certificate_number"
                        type="text"
                        @change="form?.validate('birth_certificate_number')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="birth_certificate_number"> </base-form-input-error>
                </div>
                <!-- END: Birth Certificate number -->

                <!-- BEGIN: CCP -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="ccp">
                        {{ $t('ccp') }}
                    </base-form-label>

                    <base-form-input
                        id="ccp"
                        v-model="form.ccp"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('ccp')
                            })
                        "
                        data-test="sponsor_ccp"
                        type="text"
                        @change="form?.validate('ccp')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="ccp"> </base-form-input-error>
                </div>
                <!-- END: CCP -->

                <!-- BEGIN: Function (job) -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="function">
                        {{ $t('validation.attributes.sponsor.function') }}
                    </base-form-label>

                    <base-form-input
                        id="function"
                        v-model="form.function"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.sponsor.function')
                            })
                        "
                        data-test="sponsor_function"
                        type="text"
                        @change="form?.validate('function')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="function"> </base-form-input-error>
                </div>
                <!-- END: Function (job) -->

                <!-- BEGIN: Academic Level -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="academic_level_id">
                        {{ $t('academic_level') }}
                    </base-form-label>

                    <div>
                        <the-academic-level-selector
                            id="academic_level_id"
                            v-model:academic-level="form.academic_level_id"
                            :academicLevels
                        ></the-academic-level-selector>
                    </div>

                    <base-form-input-error :form field_name="academic_level_id"> </base-form-input-error>
                </div>
                <!-- END: Academic Level -->

                <!-- BEGIN: Diploma -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="diploma">
                        {{ $t('validation.attributes.sponsor.diploma') }}
                    </base-form-label>

                    <base-form-input
                        id="diploma"
                        v-model="form.diploma"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.sponsor.diploma')
                            })
                        "
                        data-test="sponsor_diploma"
                        type="text"
                        @change="form?.validate('diploma')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="diploma"> </base-form-input-error>
                </div>
                <!-- END: Diploma -->

                <!-- BEGIN: Sponsor Type -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="sponsor_type">
                        {{ $t('filters.sponsor_type') }}
                    </base-form-label>

                    <the-sponsor-type-selector
                        id="sponsor_type"
                        v-model:type="form.sponsor_type"
                        @update:type="form?.validate('sponsor_type')"
                    ></the-sponsor-type-selector>

                    <base-form-input-error :form field_name="sponsor_type"> </base-form-input-error>
                </div>
                <!-- END: Sponsor Type -->

                <base-button :disabled="form.processing" class="col-span-12 !mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Sponsor Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
