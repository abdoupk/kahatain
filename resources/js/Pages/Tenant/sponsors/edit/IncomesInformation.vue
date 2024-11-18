<script lang="ts" setup>
import type { SponsorUpdateFormType } from '@/types/sponsors'
import type { IncomeType } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { allowOnlyNumbersOnKeyDown, omit } from '@/utils/helper'

const props = defineProps<{ sponsor: SponsorUpdateFormType }>()

const items = ref<Record<keyof IncomeType, boolean>>({
    cnr: false,
    cnas: false,
    casnos: false,
    pension: false,
    other_income: false,
    account: false
})

const toggle = (key: keyof IncomeType) => {
    form[key] = null

    items.value[key] = !items.value[key]
}

const inputs = reactive(omit(props.sponsor.incomes, ['id']))

const form = useForm('put', route('tenant.sponsors.incomes-update', props.sponsor.id), inputs)

const isChecked = (key: keyof IncomeType) => {
    if (form[key] && form[key] != false) {
        return true
    }

    return items.value[key]
}

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof SponsorUpdateFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: Incomes -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('income information') }}</h2>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-4 p-5">
                <!-- Begin: CNR -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                id="cnr"
                                :checked="isChecked('cnr')"
                                type="checkbox"
                                @click="toggle('cnr')"
                            ></base-form-switch-input>

                            <base-form-switch-label htmlFor="cnr">
                                {{ $t('incomes.label.cnr') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>

                    <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
                        <base-input-group>
                            <!-- @vue-ignore -->
                            <base-form-input
                                v-model="form.cnr"
                                :disabled="!isChecked('cnr')"
                                :placeholder="$t('validation.attributes.the_amount')"
                                maxlength="6"
                                type="text"
                                @change="form?.validate('cnr')"
                                @keydown="allowOnlyNumbersOnKeyDown"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error :form field_name="incomes.cnr" class="col-span-12 lg:col-start-5">
                    </base-form-input-error>
                </div>
                <!-- End: CNR -->

                <!-- Begin: CNAS -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                id="cnas"
                                :checked="isChecked('cnas')"
                                type="checkbox"
                                @click="toggle('cnas')"
                            ></base-form-switch-input>

                            <base-form-switch-label htmlFor="cnas">
                                {{ $t('incomes.label.cnas') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>

                    <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
                        <base-input-group>
                            <!-- @vue-ignore -->
                            <base-form-input
                                v-model="form.cnas"
                                :disabled="!isChecked('cnas')"
                                :placeholder="$t('validation.attributes.the_amount')"
                                maxlength="6"
                                type="text"
                                @change="form?.validate('cnas')"
                                @keydown="allowOnlyNumbersOnKeyDown"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error :form field_name="incomes.cnas" class="col-span-12 lg:col-start-5">
                    </base-form-input-error>
                </div>
                <!-- End: CNAS -->

                <!-- Begin: CASNOS -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                id="casnos"
                                :checked="isChecked('casnos')"
                                type="checkbox"
                                @click="toggle('casnos')"
                            ></base-form-switch-input>

                            <base-form-switch-label htmlFor="casnos">
                                {{ $t('incomes.label.casnos') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>

                    <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
                        <base-input-group>
                            <!-- @vue-ignore -->
                            <base-form-input
                                v-model="form.casnos"
                                :disabled="!isChecked('casnos')"
                                :placeholder="$t('validation.attributes.the_amount')"
                                maxlength="6"
                                type="text"
                                @change="form?.validate('casnos')"
                                @keydown="allowOnlyNumbersOnKeyDown"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error :form field_name="incomes.casnos" class="col-span-12 lg:col-start-5">
                    </base-form-input-error>
                </div>
                <!-- End: CASNOS -->

                <!-- Begin: PENSION -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                id="pension"
                                :checked="isChecked('pension')"
                                type="checkbox"
                                @click="toggle('pension')"
                            ></base-form-switch-input>

                            <base-form-switch-label htmlFor="pension">
                                {{ $t('incomes.label.pension') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>

                    <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
                        <base-input-group>
                            <!-- @vue-ignore -->
                            <base-form-input
                                v-model="form.pension"
                                :disabled="!isChecked('pension')"
                                :placeholder="$t('validation.attributes.the_amount')"
                                maxlength="6"
                                type="text"
                                @change="form?.validate('pension')"
                                @keydown="allowOnlyNumbersOnKeyDown"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error :form field_name="incomes.pension" class="col-span-12 lg:col-start-5">
                    </base-form-input-error>
                </div>
                <!-- End: PENSION -->

                <!-- Begin: OTHER -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                id="other_income"
                                :checked="isChecked('other_income')"
                                type="checkbox"
                                @click="toggle('other_income')"
                            ></base-form-switch-input>

                            <base-form-switch-label htmlFor="other_income">
                                {{ $t('incomes.label.other_income') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>

                    <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
                        <base-input-group>
                            <!-- @vue-ignore -->
                            <base-form-input
                                v-model="form.other_income"
                                :disabled="!isChecked('other_income')"
                                :placeholder="$t('validation.attributes.the_amount')"
                                maxlength="6"
                                type="text"
                                @change="form?.validate('other_income')"
                                @keydown="allowOnlyNumbersOnKeyDown"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error :form field_name="incomes.other_income" class="col-span-12 lg:col-start-5">
                    </base-form-input-error>
                </div>
                <!-- End: OTHER -->

                <!-- Begin: ACCOUNT -->
                <div class="col-span-12 grid grid-cols-12">
                    <div class="col-span-12 lg:col-span-4">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                id="account"
                                :checked="isChecked('account')"
                                type="checkbox"
                                @click="toggle('account')"
                            ></base-form-switch-input>

                            <base-form-switch-label htmlFor="account">
                                {{ $t('incomes.label.account') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>

                    <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
                        <base-input-group>
                            <!-- @vue-ignore -->
                            <base-form-input
                                v-model="form.account"
                                :disabled="!isChecked('account')"
                                :placeholder="$t('validation.attributes.the_amount')"
                                maxlength="6"
                                type="text"
                                @change="form?.validate('account')"
                                @keydown="allowOnlyNumbersOnKeyDown"
                            ></base-form-input>

                            <base-input-group-text>
                                {{ $t('DA') }}
                            </base-input-group-text>
                        </base-input-group>
                    </div>

                    <base-form-input-error :form field_name="incomes.account" class="col-span-12 lg:col-start-5">
                    </base-form-input-error>
                </div>
                <!-- End: ACCOUNT -->

                <base-button :disabled="form.processing" class="col-span-12 !mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Incomes -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
