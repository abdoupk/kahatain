<script lang="ts" setup>
import type { CreateFamilyForm, IncomeType } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { computed, onMounted, ref } from 'vue'

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
import { $t } from '@/utils/i18n'

const props = defineProps<{ form: Form<CreateFamilyForm> }>()

interface IncomesType extends IncomeType {
    ccp_account: boolean
    bank_account: boolean
}

const createFamilyStore = useCreateFamilyStore()

const _cnasFile = ref(props.form.incomes.cnas_file)

const _casnosFile = ref(props.form.incomes.casnos_file)

const _cnrFile = ref(props.form.incomes.cnr_file)

const _bankFile = ref(props.form.incomes.bank_file)

const _ccpFile = ref(props.form.incomes.ccp_file)

const totalIncome = computed(() => {
    const incomeSources = [
        createFamilyStore.family.incomes.other_income,
        createFamilyStore.family.incomes.account.ccp.performance_grant / 3,
        createFamilyStore.family.incomes.account.bank.performance_grant / 3,
        createFamilyStore.family.incomes.account.ccp.monthly_income,
        createFamilyStore.family.incomes.account.bank.balance,
        createFamilyStore.family.incomes.account.ccp.balance,
        createFamilyStore.family.incomes.account.bank.monthly_income
    ]

    return formatCurrency(incomeSources.reduce((acc, curr) => acc + Number(curr), 0))
})

const items = ref<Record<keyof IncomesType, boolean>>({
    cnr: false,
    cnas: false,
    casnos: false,
    pension: false,
    other_income: false,
    ccp_account: false,
    bank_account: false
})

const toggle = (key: keyof IncomesType) => {
    if (items.value[key]) {
        switch (key) {
            case 'other_income':
                createFamilyStore.family.incomes.other_income = null

                break

            case 'ccp_account':
                createFamilyStore.family.incomes.account.ccp = {
                    balance: null,
                    performance_grant: null,
                    monthly_income: null
                }

                break

            case 'bank_account':
                createFamilyStore.family.incomes.account.bank = {
                    balance: null,
                    performance_grant: null,
                    monthly_income: null
                }
        }
    }

    items.value[key] = !items.value[key]
}

onMounted(() => {
    const { cnr, cnas, casnos, pension, other_income, account } = createFamilyStore.family.incomes

    console.log(cnr, cnas, casnos, pension, other_income, account)

    items.value = {
        cnr: cnr,
        cnas: cnas,
        casnos: casnos,
        pension: pension,
        other_income: !!other_income,
        ccp_account: Object.values(account.ccp).some((value) => value !== null && value !== 0),
        bank_account: Object.values(account.bank).some((value) => value !== null && value !== 0)
    }

    document.getElementById('cnr')?.focus()
})
</script>

<template>
    <!-- Begin: CNR -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="cnr"
                    v-model="createFamilyStore.family.incomes.cnr"
                    :checked="items.cnr"
                    type="checkbox"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="cnr">
                    {{ $t('incomes.label.cnr') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>
    <!-- End: CNR -->

    <!-- Begin: CNAS -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="cnas"
                    v-model="createFamilyStore.family.incomes.cnas"
                    :checked="items.cnas"
                    type="checkbox"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="cnas">
                    {{ $t('incomes.label.cnas') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>
    <!-- End: CNAS -->

    <!-- Begin: CASNOS -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="casnos"
                    v-model="createFamilyStore.family.incomes.casnos"
                    :checked="items.casnos"
                    type="checkbox"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="casnos">
                    {{ $t('incomes.label.casnos') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>
    <!-- End: CASNOS -->

    <!-- Begin: PENSION -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="pension"
                    v-model="createFamilyStore.family.incomes.pension"
                    :checked="items.pension"
                    type="checkbox"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="pension">
                    {{ $t('incomes.label.pension') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
    </div>
    <!-- End: PENSION -->

    <!-- Begin: OTHER -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="other_income"
                    :checked="items.other_income"
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
                    v-model="createFamilyStore.family.incomes.other_income"
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

        <base-form-input-error :form class="col-span-12 lg:col-start-5" field_name="incomes.other_income">
        </base-form-input-error>
    </div>
    <!-- End: OTHER -->

    <!-- Begin: CCP ACCOUNT -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="ccp_account"
                    :checked="items.ccp_account"
                    type="checkbox"
                    @click="toggle('ccp_account')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="ccp_account">
                    {{ $t('incomes.label.ccp_account') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>

        <div class="col-span-12 mt-5 grid grid-cols-12 gap-3">
            <!-- Begin: MONTHLY INCOME -->
            <div class="col-span-8 lg:col-span-4">
                <base-form-label for="ccp_monthly_income">{{ $t('incomes.label.monthly_income') }}</base-form-label>

                <base-input-group>
                    <!-- @vue-ignore -->
                    <base-form-input
                        id="ccp_monthly_income"
                        v-model="createFamilyStore.family.incomes.account.ccp.monthly_income"
                        :disabled="!items.ccp_account"
                        :placeholder="$t('validation.attributes.the_amount')"
                        maxlength="6"
                        type="text"
                        @change="form?.validate('incomes.account.ccp.monthly_income')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error :form field_name="incomes.account.ccp.monthly_income"></base-form-input-error>
            </div>
            <!-- End: MONTHLY INCOME -->

            <!-- Begin: BALANCE -->
            <div class="col-span-8 lg:col-span-4">
                <base-form-label for="ccp_balance">{{ $t('incomes.label.balance') }}</base-form-label>

                <base-input-group>
                    <!-- @vue-ignore -->
                    <base-form-input
                        id="ccp_balance"
                        v-model="createFamilyStore.family.incomes.account.ccp.balance"
                        :disabled="!items.ccp_account"
                        :placeholder="$t('validation.attributes.the_amount')"
                        maxlength="6"
                        type="text"
                        @change="form?.validate('incomes.account.ccp.balance')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error :form field_name="incomes.account.ccp.balance"></base-form-input-error>
            </div>
            <!-- End: BALANCE -->

            <!-- Begin: Performance Grant -->
            <div class="col-span-8 lg:col-span-4">
                <base-form-label for="ccp_performance_grant"
                    >{{ $t('incomes.label.performance_grant') }}
                </base-form-label>

                <base-input-group>
                    <!-- @vue-ignore -->
                    <base-form-input
                        id="ccp_performance_grant"
                        v-model="createFamilyStore.family.incomes.account.ccp.performance_grant"
                        :disabled="!items.ccp_account"
                        :placeholder="$t('validation.attributes.the_amount')"
                        maxlength="6"
                        type="text"
                        @change="form?.validate('incomes.account.ccp.performance_grant')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error :form field_name="incomes.account.ccp.performance_grant">
                </base-form-input-error>
            </div>
            <!-- End: Performance Grant -->
        </div>
    </div>
    <!-- End: CCP ACCOUNT -->

    <!-- Begin: Bank ACCOUNT -->
    <div class="intro-x mt-6 grid grid-cols-12">
        <div class="col-span-12 lg:col-span-4">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="bank_account"
                    :checked="items.bank_account"
                    type="checkbox"
                    @click="toggle('bank_account')"
                ></base-form-switch-input>

                <base-form-switch-label htmlFor="bank_account">
                    {{ $t('incomes.label.bank_account') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>

        <div class="col-span-12 mt-5 grid grid-cols-12 gap-3">
            <!-- Begin: MONTHLY INCOME -->
            <div class="col-span-8 lg:col-span-4">
                <base-form-label for="bank_monthly_income">{{ $t('incomes.label.monthly_income') }}</base-form-label>

                <base-input-group>
                    <!-- @vue-ignore -->
                    <base-form-input
                        id="bank_monthly_income"
                        v-model="createFamilyStore.family.incomes.account.bank.monthly_income"
                        :disabled="!items.bank_account"
                        :placeholder="$t('validation.attributes.the_amount')"
                        maxlength="6"
                        type="text"
                        @change="form?.validate('incomes.account.bank.monthly_income')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error :form field_name="incomes.account.bank.monthly_income"></base-form-input-error>
            </div>
            <!-- End: MONTHLY INCOME -->

            <!-- Begin: BALANCE -->
            <div class="col-span-8 lg:col-span-4">
                <base-form-label for="bank_balance">{{ $t('incomes.label.balance') }}</base-form-label>

                <base-input-group>
                    <!-- @vue-ignore -->
                    <base-form-input
                        id="bank_balance"
                        v-model="createFamilyStore.family.incomes.account.bank.balance"
                        :disabled="!items.bank_account"
                        :placeholder="$t('validation.attributes.the_amount')"
                        maxlength="6"
                        type="text"
                        @change="form?.validate('incomes.account.bank.balance')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error :form field_name="incomes.account.bank.balance"></base-form-input-error>
            </div>
            <!-- End: BALANCE -->

            <!-- Begin: Performance Grant -->
            <div class="col-span-8 lg:col-span-4">
                <base-form-label for="bank_performance_grant"
                    >{{ $t('incomes.label.performance_grant') }}
                </base-form-label>

                <base-input-group>
                    <!-- @vue-ignore -->
                    <base-form-input
                        id="bank_performance_grant"
                        v-model="createFamilyStore.family.incomes.account.bank.performance_grant"
                        :disabled="!items.bank_account"
                        :placeholder="$t('validation.attributes.the_amount')"
                        maxlength="6"
                        type="text"
                        @change="form?.validate('incomes.account.bank.performance_grant')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <base-form-input-error :form field_name="incomes.account.bank.performance_grant">
                </base-form-input-error>
            </div>
            <!-- End: Performance Grant -->
        </div>
    </div>
    <!-- End: Bank ACCOUNT -->

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
    <div class="mt-6">
        <h1 class="mb-6 text-lg rtl:!font-semibold">{{ $t('upload-files.files') }}</h1>

        <div class="grid grid-cols-12 gap-3">
            <div class="col-span-12 lg:col-span-6">
                <base-form-label class="mb-2" for="cnas_file">
                    {{ $t('upload-files.labels.cnas') }}
                </base-form-label>

                <base-file-pond
                    id="cnas_file"
                    :allow-multiple="false"
                    :files="_cnasFile"
                    :is-picture="false"
                    :labelIdle="$t('upload-files.labelIdle.sponsor_cnas')"
                    accepted-file-types="image/jpeg, image/png, application/pdf"
                    @update:files="createFamilyStore.family.incomes.cnas_file = $event[0]"
                ></base-file-pond>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <base-form-label class="mb-2" for="casnos_file">
                    {{ $t('upload-files.labels.casnos') }}
                </base-form-label>

                <base-file-pond
                    id="casnos_file"
                    :allow-multiple="false"
                    :files="_casnosFile"
                    :is-picture="false"
                    :labelIdle="$t('upload-files.labelIdle.sponsor_casnos')"
                    accepted-file-types="image/jpeg, image/png, application/pdf"
                    @update:files="createFamilyStore.family.incomes.casnos_file = $event[0]"
                ></base-file-pond>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <base-form-label class="mb-2" for="cnr_file">
                    {{ $t('upload-files.labels.cnr') }}
                </base-form-label>

                <base-file-pond
                    id="cnr_file"
                    :allow-multiple="false"
                    :files="_cnrFile"
                    :is-picture="false"
                    :labelIdle="$t('upload-files.labelIdle.sponsor_cnr')"
                    accepted-file-types="image/jpeg, image/png, application/pdf"
                    @update:files="createFamilyStore.family.incomes.cnr_file = $event[0]"
                ></base-file-pond>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <base-form-label class="mb-2" for="ccp_file">
                    {{ $t('upload-files.labels.ccp') }}
                </base-form-label>

                <base-file-pond
                    id="ccp_file"
                    :allow-multiple="false"
                    :files="_ccpFile"
                    :is-picture="false"
                    :labelIdle="$t('upload-files.labelIdle.sponsor_ccp')"
                    accepted-file-types="image/jpeg, image/png, application/pdf"
                    @update:files="createFamilyStore.family.incomes.ccp_file = $event[0]"
                ></base-file-pond>
            </div>

            <div class="col-span-12 lg:col-span-6">
                <base-form-label class="mb-2" for="bank_file">
                    {{ $t('upload-files.labels.bank') }}
                </base-form-label>

                <base-file-pond
                    id="bank_file"
                    :allow-multiple="false"
                    :files="_bankFile"
                    :is-picture="false"
                    :labelIdle="$t('upload-files.labelIdle.sponsor_bank')"
                    accepted-file-types="image/jpeg, image/png, application/pdf"
                    @update:files="createFamilyStore.family.incomes.bank_file = $event[0]"
                ></base-file-pond>
            </div>
        </div>
    </div>
    <!-- End: Upload Files   -->
</template>
