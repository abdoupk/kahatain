<script lang="ts" setup>
import type { FilterValueType, ListBoxFilter } from '@/types/types'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BranchesFilterDropDown from '@/Components/Global/filters/BranchesFilterDropDown.vue'
import CitiesFilterDropDown from '@/Components/Global/filters/CitiesFilterDropDown.vue'
import ClothesSizeFilterDropDown from '@/Components/Global/filters/ClothesSizeFilterDropDown.vue'
import CollegeAcademicLevelFilterDropDown from '@/Components/Global/filters/CollegeAcademicLevelFilterDropDown.vue'
import CollegeSpecialityFilterDropDown from '@/Components/Global/filters/CollegeSpecialityFilterDropDown.vue'
import EidAlAdhaStatusFilterDropDown from '@/Components/Global/filters/EidAlAdhaStatusFilterDropDown.vue'
import FamiliesFilterDropDown from '@/Components/Global/filters/FamiliesFilterDropDown.vue'
import FinanceSpecificationFilterDropDown from '@/Components/Global/filters/FinanceSpecificationFilterDropDown.vue'
import FinanceTypeFilterDropDown from '@/Components/Global/filters/FinanceTypeFilterDropDown.vue'
import FurnishingsFilterDropDown from '@/Components/Global/filters/FurnishingsFilterDropDown.vue'
import GenderTypeFilterDropDown from '@/Components/Global/filters/GenderTypeFilterDropDown.vue'
import InstituteFilterDropDown from '@/Components/Global/filters/InstituteFilterDropDown.vue'
import MemberAcademicLevelFilterDropDown from '@/Components/Global/filters/MemberAcademicLevelFilterDropDown.vue'
import MembersFilterDropDown from '@/Components/Global/filters/MembersFilterDropDown.vue'
import NeedStatusFilterDropDown from '@/Components/Global/filters/NeedStatusFilterDropDown.vue'
import NeedableTypeFilterDropDown from '@/Components/Global/filters/NeedableTypeFilterDropDown.vue'
import OrphanAcademicLevelFilterDropDown from '@/Components/Global/filters/OrphanAcademicLevelFilterDropDown.vue'
import OrphansFilterDropDown from '@/Components/Global/filters/OrphansFilterDropDown.vue'
import RamadanBasketCategoryFilterDropDown from '@/Components/Global/filters/RamadanBasketCategoryFilterDropDown.vue'
import SchoolFilterDropDown from '@/Components/Global/filters/SchoolFilterDropDown.vue'
import ShoesSizeFilterDropDown from '@/Components/Global/filters/ShoesSizeFilterDropDown.vue'
import SpecialityFilterDropDown from '@/Components/Global/filters/SpecialityFilterDropDown.vue'
import SponsorAcademicLevelFilterDropDown from '@/Components/Global/filters/SponsorAcademicLevelFilterDropDown.vue'
import SponsorTypeFilterDropDown from '@/Components/Global/filters/SponsorTypeFilterDropDown.vue'
import SponsorsFilterDropDown from '@/Components/Global/filters/SponsorsFilterDropDown.vue'
import TraineeAcademicLevelFilterDropDown from '@/Components/Global/filters/TraineeAcademicLevelFilterDropDown.vue'
import TraineeSpecialityFilterDropDown from '@/Components/Global/filters/TraineeSpecialityFilterDropDown.vue'
import UniversityFilterDropDown from '@/Components/Global/filters/UniversityFilterDropDown.vue'
import ZonesFilterDropDown from '@/Components/Global/filters/ZonesFilterDropDown.vue'

defineProps<{ field?: ListBoxFilter }>()

const value = defineModel<FilterValueType>('value')
</script>

<template>
    <div class="col-span-6 md:col-span-4">
        <template v-if="field?.type === 'object'">
            <families-filter-drop-down
                v-if="field?.label === 'family'"
                v-model:value="value"
                class="text-sm"
            ></families-filter-drop-down>

            <sponsors-filter-drop-down
                v-else-if="field?.label === 'sponsor'"
                v-model:value="value"
                class="text-sm"
            ></sponsors-filter-drop-down>

            <cities-filter-drop-down
                v-else-if="field?.label === 'location'"
                v-model:value="value"
                class="text-sm"
            ></cities-filter-drop-down>

            <members-filter-drop-down
                v-else-if="
                    field?.label === 'branch_president' || field?.label === 'creator' || field?.label === 'receiver'
                "
                v-model:value="value"
                class="text-sm"
            ></members-filter-drop-down>

            <orphans-filter-drop-down
                v-else-if="field?.label === 'orphan'"
                v-model:value="value"
                class="text-sm"
            ></orphans-filter-drop-down>

            <branches-filter-drop-down
                v-else-if="field?.label === 'branch'"
                v-model:value="value"
                class="text-sm"
            ></branches-filter-drop-down>

            <zones-filter-drop-down
                v-else-if="field?.label === 'zone'"
                v-model:value="value"
                class="text-sm"
            ></zones-filter-drop-down>

            <shoes-size-filter-drop-down
                v-else-if="field?.label === 'shoes_size'"
                v-model:value="value"
                class="text-sm"
            ></shoes-size-filter-drop-down>

            <clothes-size-filter-drop-down
                v-else-if="field?.label === 'pants_size' || field?.label === 'shirt_size'"
                v-model:value="value"
                class="text-sm"
            ></clothes-size-filter-drop-down>

            <sponsor-academic-level-filter-drop-down
                v-else-if="field?.label === 'sponsor_academic_level' || field?.label === 'sponsor.academic_level'"
                v-model:value="value"
                class="text-sm"
            ></sponsor-academic-level-filter-drop-down>

            <orphan-academic-level-filter-drop-down
                v-else-if="field?.label === 'orphan_academic_level' || field?.label === 'orphan.academic_level'"
                v-model:value="value"
                class="text-sm"
            ></orphan-academic-level-filter-drop-down>

            <college-academic-level-filter-drop-down
                v-else-if="field?.label === 'college_student_academic_level'"
                v-model:value="value"
                class="text-sm"
            ></college-academic-level-filter-drop-down>

            <trainee-academic-level-filter-drop-down
                v-else-if="field?.label === 'trainee_student_academic_level'"
                v-model:value="value"
                class="text-sm"
            ></trainee-academic-level-filter-drop-down>

            <speciality-filter-drop-down
                v-else-if="field?.label === 'speciality'"
                v-model:value="value"
                class="text-sm"
            ></speciality-filter-drop-down>

            <college-speciality-filter-drop-down
                v-else-if="field?.label === 'college_speciality'"
                v-model:value="value"
                class="text-sm"
            ></college-speciality-filter-drop-down>

            <trainee-speciality-filter-drop-down
                v-else-if="field?.label === 'trainee_speciality'"
                v-model:value="value"
                class="text-sm"
            ></trainee-speciality-filter-drop-down>

            <eid-al-adha-status-filter-drop-down
                v-else-if="field?.field === 'eid_al_adha_status'"
                v-model:value="value"
                class="text-sm"
            ></eid-al-adha-status-filter-drop-down>

            <need-status-filter-drop-down
                v-else-if="field?.field === 'status' && field?.label !== 'eid_al_adha_status'"
                v-model:value="value"
                class="text-sm"
            ></need-status-filter-drop-down>

            <needable-type-filter-drop-down
                v-else-if="field?.label === 'recipient_type'"
                v-model:value="value"
                class="text-sm"
            ></needable-type-filter-drop-down>

            <ramadan-basket-category-filter-drop-down
                v-else-if="field?.label === 'ramadan_basket_category'"
                v-model:value="value"
                class="text-sm"
            ></ramadan-basket-category-filter-drop-down>

            <institute-filter-drop-down
                v-else-if="field?.label === 'institute'"
                v-model:value="value"
                class="text-sm"
            ></institute-filter-drop-down>

            <university-filter-drop-down
                v-else-if="field?.label === 'university'"
                v-model:value="value"
                class="text-sm"
            ></university-filter-drop-down>

            <school-filter-drop-down
                v-else-if="field?.label === 'school'"
                v-model:value="value"
                class="text-sm"
            ></school-filter-drop-down>

            <member-academic-level-filter-drop-down
                v-else-if="field?.label === 'member_academic_level' || field?.label === 'member.academic_level'"
                v-model:value="value"
                class="text-sm"
            ></member-academic-level-filter-drop-down>

            <sponsor-type-filter-drop-down
                v-if="field?.label === 'sponsor_type'"
                v-model:value="value"
                class="text-sm"
            ></sponsor-type-filter-drop-down>

            <gender-type-filter-drop-down
                v-if="field?.label === 'gender'"
                v-model:value="value"
                class="text-sm"
            ></gender-type-filter-drop-down>

            <furnishings-filter-drop-down
                v-if="field?.label === 'furnishings'"
                v-model="value"
                class="text-sm"
            ></furnishings-filter-drop-down>

            <finance-type-filter-drop-down
                v-if="field?.label === 'finance_type'"
                v-model:value="value"
                class="text-sm"
            ></finance-type-filter-drop-down>

            <finance-specification-filter-drop-down
                v-if="field?.label === 'finance_specification'"
                v-model:value="value"
                class="text-sm"
            ></finance-specification-filter-drop-down>
        </template>

        <template v-else-if="field?.type === 'date'">
            <div class="mt-2">
                <base-v-calendar v-model="value"></base-v-calendar>
            </div>
        </template>

        <base-form-input
            v-else-if="field?.type === 'string'"
            v-model="value"
            :placeholder="
                $t('auth.placeholders.fill', {
                    attribute: $t('the_value')
                })
            "
            class="mt-2 text-sm"
            type="text"
        ></base-form-input>

        <base-form-input
            v-else-if="field?.type === 'number'"
            v-model="value"
            :placeholder="
                $t('auth.placeholders.fill', {
                    attribute: $t('the_value')
                })
            "
            class="mt-2 text-sm"
            type="number"
        ></base-form-input>

        <base-form-select v-else-if="field?.type === 'boolean'" v-model="value" class="mt-2 text-sm">
            <option :value="true" selected>{{ $t('yes') }}</option>
            <option :value="false">{{ $t('no') }}</option>
        </base-form-select>
    </div>
</template>
