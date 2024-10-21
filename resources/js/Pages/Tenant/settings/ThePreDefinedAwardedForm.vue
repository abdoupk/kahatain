<script lang="ts" setup>
import type { CalculationTableType } from '@/types/settings'

import { useForm } from 'laravel-precognition-vue'
import { ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{
    calculation: CalculationTableType
}>()

const showSuccessNotification = ref(false)

const form = useForm('patch', route('tenant.site-settings.update-awarded-infos'), {
    university_scholarship: props.calculation.university_scholarship,
    unemployment_benefit: props.calculation.unemployment_benefit
})

const submit = () => {
    form.submit({
        onSuccess: () => {
            showSuccessNotification.value = true

            setTimeout(() => {
                showSuccessNotification.value = false
            }, 1000)
        }
    })
}
</script>

<template>
    <div class="intro-y box h-fit @container">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('general_information_of_association') }}</h2>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-3 px-5 pb-5 lg:pt-5">
                <!-- BEGIN: Unemployment benefit -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-label class="mt-1.5 text-lg" for="unemployment_benefit">
                            {{ $t('settings.unemployment_benefit') }}
                        </base-form-label>
                    </div>

                    <div class="col-span-10 lg:col-span-8">
                        <base-input-group>
                            <!-- @vue-ignore -->
                            <base-form-input
                                id="unemployment_benefit"
                                v-model="form.unemployment_benefit"
                                :placeholder="$t('validation.attributes.the_amount')"
                                max="50000"
                                maxlength="5"
                                type="text"
                                @change="form?.validate('unemployment_benefit')"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error class="col-span-12 lg:col-start-5">
                        <div v-if="form?.invalid('unemployment_benefit')" class="mt-2 text-danger">
                            {{ form.errors.unemployment_benefit }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- End: Unemployment benefit -->

                <!-- BEGIN: University Scholarship -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-label class="mt-0 text-lg lg:mt-0" for="university_scholarship">
                            {{ $t('settings.university_scholarship') }}
                        </base-form-label>
                    </div>

                    <div class="col-span-10 lg:col-span-8">
                        <base-input-group>
                            <base-form-input
                                id="university_scholarship"
                                v-model="form.university_scholarship"
                                :placeholder="$t('settings.university_scholarship_hint')"
                                max="50000"
                                maxlength="5"
                                type="text"
                                @change="form?.validate('university_scholarship')"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error class="col-span-12 lg:col-start-5">
                        <div v-if="form?.invalid('university_scholarship')" class="mt-2 text-danger">
                            {{ form.errors.university_scholarship }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- End: University Scholarship -->

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
</template>
