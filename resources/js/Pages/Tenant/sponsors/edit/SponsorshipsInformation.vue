<script lang="ts" setup>
import type { SponsorSponsorshipType } from '@/types/families'
import type { SponsorUpdateFormType } from '@/types/sponsors'
import type { SponsorSponsorship } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { omit } from '@/utils/helper'

const props = defineProps<{
    sponsor: SponsorUpdateFormType
}>()

// eslint-disable-next-line array-element-newline
const inputs = reactive<Omit<SponsorSponsorshipType, 'id'>>(omit(props.sponsor.sponsorships, ['id']))

for (const key in inputs) {
    inputs[key as SponsorSponsorship] =
        inputs[key as SponsorSponsorship] === '0'
            ? false
            : inputs[key as SponsorSponsorship] === '1'
              ? true
              : inputs[key as SponsorSponsorship]
}

const form = useForm('put', route('tenant.sponsors.sponsorships-update', props.sponsor.id), inputs)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof Omit<SponsorSponsorshipType, 'id'>)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}

const items = ref<Record<SponsorSponsorship, boolean>>({
    medical_sponsorship: false,
    literacy_lessons: false,
    direct_sponsorship: false,
    project_support: false
})

const toggle = (key: SponsorSponsorship) => {
    form[key] = false

    items.value[key] = !items.value[key]
}

const isChecked = (key: SponsorSponsorship) => {
    if (form[key] && form[key] !== false) {
        return true
    }

    return items.value[key]
}

const setValue = (key: SponsorSponsorship, event: Event) => {
    form[key] = (event.target as HTMLInputElement).value
}
</script>

<template>
    <!-- BEGIN: Sponsorships Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('sponsor_sponsorship') }}</h2>
        </div>
        <form @submit.prevent="submit">
            <div class="col-span-12 grid grid-cols-12 gap-4 p-5">
                <!-- Begin: monthly Allowance -->
                <div class="col-span-12">
                    <div class="grid grid-cols-12">
                        <div class="col-span-12 lg:col-span-4">
                            <base-form-switch class="text-lg">
                                <base-form-switch-input
                                    id="medical_sponsorship"
                                    :checked="isChecked('medical_sponsorship')"
                                    type="checkbox"
                                    @change="toggle('medical_sponsorship')"
                                ></base-form-switch-input>

                                <base-form-switch-label htmlFor="medical_sponsorship">
                                    {{ $t('sponsorships.medical_sponsorship') }}
                                </base-form-switch-label>
                            </base-form-switch>
                        </div>

                        <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                            <base-form-text-area
                                :disabled="!isChecked('medical_sponsorship')"
                                :placeholder="$t('notes')"
                                :value="typeof form.medical_sponsorship === 'boolean' ? null : form.medical_sponsorship"
                                class="w-full md:w-3/4"
                                rows="4"
                                @input="setValue('medical_sponsorship', $event)"
                            ></base-form-text-area>
                        </div>
                    </div>
                </div>
                <!-- End: monthly Allowance -->

                <!-- Begin: monthly Allowance -->
                <div class="col-span-12">
                    <div class="grid grid-cols-12">
                        <div class="col-span-12 lg:col-span-4">
                            <base-form-switch class="text-lg">
                                <base-form-switch-input
                                    id="literacy_lessons"
                                    :checked="isChecked('literacy_lessons')"
                                    type="checkbox"
                                    @change="toggle('literacy_lessons')"
                                ></base-form-switch-input>

                                <base-form-switch-label htmlFor="literacy_lessons">
                                    {{ $t('sponsorships.literacy_lessons') }}
                                </base-form-switch-label>
                            </base-form-switch>
                        </div>

                        <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                            <base-form-text-area
                                :disabled="!isChecked('literacy_lessons')"
                                :placeholder="$t('notes')"
                                :value="typeof form.literacy_lessons === 'boolean' ? null : form.literacy_lessons"
                                class="w-full md:w-3/4"
                                rows="4"
                                @input="setValue('literacy_lessons', $event)"
                            ></base-form-text-area>
                        </div>
                    </div>
                </div>
                <!-- End: monthly Allowance -->

                <!-- Begin: monthly Allowance -->
                <div class="col-span-12">
                    <div class="grid grid-cols-12">
                        <div class="col-span-12 lg:col-span-4">
                            <base-form-switch class="text-lg">
                                <base-form-switch-input
                                    id="direct_sponsorship"
                                    :checked="isChecked('direct_sponsorship')"
                                    type="checkbox"
                                    @change="toggle('direct_sponsorship')"
                                ></base-form-switch-input>

                                <base-form-switch-label htmlFor="direct_sponsorship">
                                    {{ $t('sponsorships.direct_sponsorship') }}
                                </base-form-switch-label>
                            </base-form-switch>
                        </div>

                        <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                            <base-form-text-area
                                :disabled="!isChecked('direct_sponsorship')"
                                :placeholder="$t('notes')"
                                :value="typeof form.direct_sponsorship === 'boolean' ? null : form.direct_sponsorship"
                                class="w-full md:w-3/4"
                                rows="4"
                                @input="setValue('direct_sponsorship', $event)"
                            ></base-form-text-area>
                        </div>
                    </div>
                </div>
                <!-- End: monthly Allowance -->

                <!-- Begin: monthly Allowance -->
                <div class="col-span-12">
                    <div class="grid grid-cols-12">
                        <div class="col-span-12 lg:col-span-4">
                            <base-form-switch class="text-lg">
                                <base-form-switch-input
                                    id="project_support"
                                    :checked="isChecked('project_support')"
                                    type="checkbox"
                                    @change="toggle('project_support')"
                                ></base-form-switch-input>

                                <base-form-switch-label htmlFor="project_support">
                                    {{ $t('sponsorships.project_support') }}
                                </base-form-switch-label>
                            </base-form-switch>
                        </div>

                        <div class="col-span-12 mt-3 lg:col-span-8 lg:mt-0">
                            <base-form-text-area
                                :disabled="!isChecked('project_support')"
                                :placeholder="$t('notes')"
                                :value="typeof form.project_support === 'boolean' ? null : form.project_support"
                                class="w-full md:w-3/4"
                                rows="4"
                                @input="setValue('project_support', $event)"
                            ></base-form-text-area>
                        </div>
                    </div>
                </div>
                <!-- End: monthly Allowance -->

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Sponsorships Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
