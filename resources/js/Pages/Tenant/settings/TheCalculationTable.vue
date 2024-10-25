<script lang="ts" setup>
import type { CalculationTableType } from '@/types/settings'

import { useForm } from 'laravel-precognition-vue'
import { ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTdTable from '@/Components/Base/table/BaseTdTable.vue'
import BaseThTable from '@/Components/Base/table/BaseThTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{
    calculation: CalculationTableType
}>()

const form = useForm<CalculationTableType>(
    'patch',
    route('tenant.site-settings.update-calculation-weights'),
    props.calculation
)

const showSuccessNotification = ref(false)

const submit = () =>
    form.submit({
        onSuccess() {
            showSuccessNotification.value = true

            setTimeout(() => {
                showSuccessNotification.value = false
            }, 1000)
        }
    })
</script>

<template>
    <div class="intro-y box col-span-12 @container">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('calculate_the_income_rate') }}</h2>
        </div>

        <form @submit.prevent="submit">
            <div class="col-span-12 overflow-x-auto p-5 lg:overflow-x-hidden">
                <base-table bordered>
                    <base-thead-table>
                        <base-th-table>{{ $t('settings.family_members') }}</base-th-table>
                        <base-th-table>{{ $t('settings.weight') }}</base-th-table>
                        <base-th-table
                            >{{ $t('settings.the_real_income_of_the_employee_and_those_receiving_a_grant') }}
                        </base-th-table>
                        <base-th-table>{{ $t('settings.percentage_of_contribution_to_family_income') }}</base-th-table>
                        <base-th-table>
                            {{ $t('settings.default_contribution_to_income_if_unemployment') }}
                        </base-th-table>
                        <base-th-table>{{ $t('settings.contribution_to_income') }}</base-th-table>
                    </base-thead-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.main_sponsor') }}</base-td-table>
                        <base-td-table></base-td-table>
                        <base-td-table rowspan="7"></base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input disabled type="number" value="100"></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table></base-td-table>
                        <base-td-table rowspan="7">
                            <base-input-group>
                                <base-form-input disabled type="number" value="100"></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('sponsor_types.widower') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.sponsor.widower"></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.sponsor.widower"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.sponsor.widower"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('sponsor_types.widow') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.sponsor.widow"></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.sponsor.widow"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.sponsor.widow"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('sponsor_types.widows_husband') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.sponsor.widows_husband"></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.sponsor.widows_husband"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.sponsor.widows_husband"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('sponsor_types.widowers_wife') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.sponsor.widowers_wife"></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.sponsor.widowers_wife"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.sponsor.widowers_wife"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('sponsor_types.other') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.sponsor.other"></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.sponsor.other"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.sponsor.other"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('sponsor_types.mother_of_a_supported_childhood') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.sponsor.mother_of_a_supported_childhood"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.sponsor.mother_of_a_supported_childhood"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.sponsor.mother_of_a_supported_childhood"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-thead-table>
                        <base-th-table
                            >{{ $t('settings.children_under_18_years_old_or_students_over_18_years_old') }}
                        </base-th-table>
                        <base-th-table>{{ $t('settings.weight_outside_the_academic_season') }}</base-th-table>
                        <base-th-table>{{ $t('settings.weight_during_the_academic_season') }}</base-th-table>
                        <base-th-table colspan="3">{{ $t('settings.without_income') }}</base-th-table>
                    </base-thead-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.baby') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.outside_academic_season.baby"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.during_academic_season.baby"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table class="border-0 border-e" colspan="3"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.below_school_age') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.outside_academic_season.below_school_age"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.during_academic_season.below_school_age"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table class="border-0 border-e" colspan="3"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.elementary_school') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.outside_academic_season.elementary_school"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.during_academic_season.elementary_school"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table class="border-0 border-e" colspan="3"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.middle_school') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.outside_academic_season.middle_school"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.during_academic_season.middle_school"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table class="border-0"></base-td-table>
                        <base-td-table class="border-0 border-e" colspan="3"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.high_school') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.outside_academic_season.high_school"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.during_academic_season.high_school"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table class="border-0 border-e" colspan="3"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.professional_boy') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.outside_academic_season.professionals"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.during_academic_season.professionals"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table class="border-0 border-e" colspan="3"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.dismissed') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.outside_academic_season.dismissed"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.lt_18.during_academic_season.dismissed"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table class="border-0 border-e" colspan="3"></base-td-table>
                    </base-tr-table>
                    <base-tr-table class="text-center">
                        <base-td-table>{{ $t('settings.females_over_18_years_old') }}</base-td-table>
                        <base-td-table>{{ $t('settings.weight') }}</base-td-table>
                        <base-td-table
                            >{{ $t('settings.real_income_is_a_grant_plus_retirement_plus_salary') }}
                        </base-td-table>
                        <base-td-table>{{ $t('settings.percentage_of_contribution_to_income') }}</base-td-table>
                        <base-td-table>{{ $t('settings.default_unemployment_female_contribution') }}</base-td-table>
                        <base-td-table>{{ $t('settings.contribution_to_income') }}</base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.college_girl') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.orphans.female_gt_18.college_girl"></base-form-input>
                        </base-td-table>
                        <base-td-table rowspan="8"></base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.female_gt_18.college_girl"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table colspan="2" rowspan="2"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.professional_girl') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.female_gt_18.professional_girl"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.female_gt_18.professional_girl"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.at_home_with_no_income') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.female_gt_18.at_home_with_no_income"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table></base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.orphans.female_gt_18.at_home_with_no_income"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.orphans.female_gt_18.at_home_with_no_income"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.at_home_with_income') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.female_gt_18.at_home_with_income"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.female_gt_18.at_home_with_income"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table colspan="2" rowspan="5"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.single_female_employee') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.female_gt_18.single_female_employee"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="
                                        form.percentage_of_contribution.orphans.female_gt_18.single_female_employee
                                    "
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.married') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.orphans.female_gt_18.married"></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.female_gt_18.married"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>

                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.divorced_with_family') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.female_gt_18.divorced_with_family"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.female_gt_18.divorced_with_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>

                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.divorced_outside_family') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.female_gt_18.divorced_outside_family"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="
                                        form.percentage_of_contribution.orphans.female_gt_18.divorced_outside_family
                                    "
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>

                    <base-tr-table class="text-center">
                        <base-td-table>{{ $t('settings.males_over_18_years_old') }}</base-td-table>
                        <base-td-table>{{ $t('settings.weight') }}</base-td-table>
                        <base-td-table>{{ $t('settings.real_income_grant_plus_salary') }}</base-td-table>
                        <base-td-table>{{ $t('settings.percentage_of_contribution_to_income') }}</base-td-table>
                        <base-td-table>{{ $t('settings.default_unemployment_male_contribution') }}</base-td-table>
                        <base-td-table>{{ $t('settings.contribution_to_income') }}</base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.college_boy') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.orphans.male_gt_18.college_boy"></base-form-input>
                        </base-td-table>
                        <base-td-table rowspan="7"></base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.male_gt_18.college_boy"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table></base-td-table>
                        <base-td-table rowspan="7"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.professional_boy') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.male_gt_18.professional_boy"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table></base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.orphans.male_gt_18.professional_boy"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.unemployed') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.orphans.male_gt_18.unemployed"></base-form-input>
                        </base-td-table>
                        <base-td-table></base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.orphans.male_gt_18.unemployed"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.worker_with_family') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.male_gt_18.worker_with_family"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.male_gt_18.worker_with_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table rowspan="2"></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.worker_outside_family') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.male_gt_18.worker_outside_family"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.male_gt_18.worker_outside_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.married_with_family') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.male_gt_18.married_with_family"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.male_gt_18.married_with_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.unemployed_contribution.orphans.male_gt_18.married_with_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.married_outside_family') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                v-model="form.weights.orphans.male_gt_18.married_outside_family"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.orphans.male_gt_18.married_outside_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table></base-td-table>
                    </base-tr-table>
                    <base-tr-table>
                        <base-td-table>{{ $t('settings.special_cases') }}</base-td-table>
                        <base-td-table>{{ $t('settings.weight') }}</base-td-table>
                        <base-td-table>{{ $t('settings.real_income') }}</base-td-table>
                        <base-td-table>{{ $t('settings.percentage_of_contribution_to_income') }}</base-td-table>
                        <base-td-table colspan="2"></base-td-table>
                    </base-tr-table>

                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.second_sponsor_with_family') }}</base-td-table>

                        <base-td-table>
                            <base-form-input v-model="form.weights.second_sponsor.with_family"></base-form-input>
                        </base-td-table>

                        <base-td-table></base-td-table>

                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.second_sponsor.with_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table colspan="3"></base-td-table>
                    </base-tr-table>

                    <base-tr-table>
                        <base-td-table>{{ $t('family_statuses.second_sponsor_outside_family') }}</base-td-table>
                        <base-td-table>
                            <base-form-input
                                disabled
                                v-model="form.weights.second_sponsor.outside_family"
                            ></base-form-input>
                        </base-td-table>
                        <base-td-table></base-td-table>

                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.percentage_of_contribution.second_sponsor.outside_family"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text> %</base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table colspan="3"></base-td-table>
                    </base-tr-table>

                    <base-tr-table>
                        <base-td-table>{{ $t('settings.handicapped') }}</base-td-table>
                        <base-td-table>
                            <base-form-input v-model="form.weights.handicapped"></base-form-input>
                        </base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.handicapped_contribution.income"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                        <base-td-table colspan="2"></base-td-table>
                        <base-td-table>
                            <base-input-group>
                                <base-form-input
                                    v-model="form.handicapped_contribution.contribution"
                                    type="number"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>
                        </base-td-table>
                    </base-tr-table>
                </base-table>

                <base-button :disabled="form.processing" class="!mt-5 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>

    <success-notification
        :open="showSuccessNotification"
        :title="
            $t('successfully_updated', {
                attribute: $t('tenant_settings')
            })
        "
    ></success-notification>
</template>
