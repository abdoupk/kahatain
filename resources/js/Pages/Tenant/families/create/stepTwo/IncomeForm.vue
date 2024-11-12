<script lang="ts" setup>
import type { CreateFamilyForm, IncomeType } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'
import { computed, ref } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'

import { allowOnlyNumbersOnKeyDown, formatCurrency } from '@/utils/helper'

defineProps<{ form: Form<CreateFamilyForm> }>()

const cnr = defineModel('cnr')

const cnas = defineModel('cnas')

const casnos = defineModel('casnos')

const pension = defineModel('pension')

const account = defineModel('account')

const other_income = defineModel('other_income')

const totalIncome = computed(() => {
    let totalIncome =
        Number(cnr.value) +
        Number(cnas.value) +
        Number(casnos.value) +
        Number(pension.value) +
        Number(other_income.value) +
        Number(account.value)

    return formatCurrency(totalIncome)
})

const items = ref<Record<keyof IncomeType, boolean>>({
    cnr: false,
    cnas: false,
    casnos: false,
    pension: false,
    other_income: false,
    account: true
})

const toggle = (key: keyof IncomeType) => {
    items.value[key] = !items.value[key]
}
</script>

<template>
    <!-- Begin: CNR -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input id="cnr" type="checkbox" @click="toggle('cnr')"></base-form-switch-input>

                <base-form-switch-label htmlFor="cnr">
                    {{ $t('incomes.label.cnr') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>

        <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
            <base-input-group>
                <!-- @vue-ignore -->
                <base-form-input
                    v-model="cnr"
                    :disabled="!items.cnr"
                    :placeholder="$t('validation.attributes.the_amount')"
                    maxlength="6"
                    type="text"
                    @change="form?.validate('incomes.cnr')"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>
        </div>

        <base-form-input-error class="col-span-12 lg:col-start-5">
            <!-- @vue-ignore -->
            <div v-if="form?.invalid('incomes.cnr')" class="mt-2 text-danger">
                {{
                    // @ts-ignore
                    form.errors['incomes.cnr']
                }}
            </div>
        </base-form-input-error>
    </div>
    <!-- End: CNR -->

    <!-- Begin: CNAS -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input id="cnas" type="checkbox" @click="toggle('cnas')"></base-form-switch-input>

                <base-form-switch-label htmlFor="cnas">
                    {{ $t('incomes.label.cnas') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>

        <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
            <base-input-group>
                <!-- @vue-ignore -->
                <base-form-input
                    v-model="cnas"
                    :disabled="!items.cnas"
                    :placeholder="$t('validation.attributes.the_amount')"
                    maxlength="6"
                    type="text"
                    @change="form?.validate('incomes.cnas')"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>
        </div>

        <base-form-input-error class="col-span-12 lg:col-start-5">
            <!-- @vue-ignore -->
            <div v-if="form?.invalid('incomes.cnas')" class="mt-2 text-danger">
                {{
                    // @ts-ignore
                    form.errors['incomes.cnas']
                }}
            </div>
        </base-form-input-error>
    </div>
    <!-- End: CNAS -->

    <!-- Begin: CASNOS -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input id="casnos" type="checkbox" @click="toggle('casnos')"></base-form-switch-input>

                <base-form-switch-label htmlFor="casnos">
                    {{ $t('incomes.label.casnos') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>

        <div class="col-span-8 mt-3 lg:col-span-3 lg:mt-0">
            <base-input-group>
                <!-- @vue-ignore -->
                <base-form-input
                    v-model="casnos"
                    :disabled="!items.casnos"
                    :placeholder="$t('validation.attributes.the_amount')"
                    maxlength="6"
                    type="text"
                    @change="form?.validate('incomes.casnos')"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>
        </div>

        <base-form-input-error class="col-span-12 lg:col-start-5">
            <!-- @vue-ignore -->
            <div v-if="form?.invalid('incomes.casnos')" class="mt-2 text-danger">
                {{
                    // @ts-ignore
                    form.errors['incomes.casnos']
                }}
            </div>
        </base-form-input-error>
    </div>
    <!-- End: CASNOS -->

    <!-- Begin: PENSION -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="pension"
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
                    v-model="pension"
                    :disabled="!items.pension"
                    :placeholder="$t('validation.attributes.the_amount')"
                    maxlength="6"
                    type="text"
                    @change="form?.validate('incomes.pension')"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>
        </div>

        <base-form-input-error class="col-span-12 lg:col-start-5">
            <!-- @vue-ignore -->
            <div v-if="form?.invalid('incomes.pension')" class="mt-2 text-danger">
                {{
                    // @ts-ignore
                    form.errors['incomes.pension']
                }}
            </div>
        </base-form-input-error>
    </div>
    <!-- End: PENSION -->

    <!-- Begin: OTHER -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="other_income"
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
                    v-model="other_income"
                    :disabled="!items.other_income"
                    :placeholder="$t('validation.attributes.the_amount')"
                    maxlength="6"
                    type="text"
                    @change="form?.validate('incomes.other_income')"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>
        </div>

        <base-form-input-error class="col-span-12 lg:col-start-5">
            <!-- @vue-ignore -->
            <div v-if="form?.invalid('incomes.other_income')" class="mt-2 text-danger">
                {{
                    // @ts-ignore
                    form.errors['incomes.other_income']
                }}
            </div>
        </base-form-input-error>
    </div>
    <!-- End: OTHER -->

    <!-- Begin: ACCOUNT -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="account"
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
                    v-model="account"
                    :disabled="!items.account"
                    :placeholder="$t('validation.attributes.the_amount')"
                    maxlength="6"
                    type="text"
                    @change="form?.validate('incomes.account')"
                    @keydown="allowOnlyNumbersOnKeyDown"
                ></base-form-input>

                <base-input-group-text>
                    {{ $t('DA') }}
                </base-input-group-text>
            </base-input-group>
        </div>

        <base-form-input-error class="col-span-12 lg:col-start-5">
            <!-- @vue-ignore -->
            <div v-if="form?.invalid('incomes.account')" class="mt-2 text-danger">
                {{
                    // @ts-ignore
                    form.errors['incomes.account']
                }}
            </div>
        </base-form-input-error>
    </div>
    <!-- End: ACCOUNT -->

    <hr class="mb-4 mt-6" />

    <!-- Begin: TOTAL INCOME -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <p class="col-span-4 ms-0 text-lg lg:ms-11">
            {{ $t('incomes.label.total_income') }}
        </p>
        <p class="col-span-8 text-base font-bold">{{ totalIncome }}</p>
    </div>
    <!-- End: TOTAL INCOME -->

    <!-- Begin: Upload files  -->
    <div class="mt-4">
        <h1 class="mb-6 text-lg">files</h1>
        <div class="w-3/5">
            <base-form-label>cnas</base-form-label>

            <base-file-pond></base-file-pond>
        </div>
    </div>
    <!-- End: Upload Files   -->
</template>
