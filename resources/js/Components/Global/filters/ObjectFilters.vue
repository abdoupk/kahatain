<script lang="ts" setup>
import { ListBoxFilter } from '@/types/types'

import { defineAsyncComponent } from 'vue'

import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'

defineProps<{ field: ListBoxFilter }>()

const value = defineModel('value')

const BranchesFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/BranchesFilterDropDown.vue')
)

const CitiesFilterDropDown = defineAsyncComponent(() => import('@/Components/Global/filters/CitiesFilterDropDown.vue'))

const ClothesSizeFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/ClothesSizeFilterDropDown.vue')
)

const CollegeAcademicLevelFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/CollegeAcademicLevelFilterDropDown.vue')
)

const CollegeSpecialityFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/CollegeSpecialityFilterDropDown.vue')
)

const EidAlAdhaStatusFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/EidAlAdhaStatusFilterDropDown.vue')
)

const FamiliesFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/FamiliesFilterDropDown.vue')
)

const FinanceSpecificationFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/FinanceSpecificationFilterDropDown.vue')
)

const FinanceTypeFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/FinanceTypeFilterDropDown.vue')
)

const FurnishingsFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/FurnishingsFilterDropDown.vue')
)

const GenderTypeFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/GenderTypeFilterDropDown.vue')
)

const InstituteFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/InstituteFilterDropDown.vue')
)

const MemberAcademicLevelFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/MemberAcademicLevelFilterDropDown.vue')
)

const MembersFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/MembersFilterDropDown.vue')
)

const NeedStatusFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/NeedStatusFilterDropDown.vue')
)

const NeedableTypeFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/NeedableTypeFilterDropDown.vue')
)

const OrphanAcademicLevelFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/OrphanAcademicLevelFilterDropDown.vue')
)

const OrphansFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/OrphansFilterDropDown.vue')
)

const RamadanBasketCategoryFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/RamadanBasketCategoryFilterDropDown.vue')
)

const SchoolFilterDropDown = defineAsyncComponent(() => import('@/Components/Global/filters/SchoolFilterDropDown.vue'))

const ShoesSizeFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/ShoesSizeFilterDropDown.vue')
)

const SpecialityFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/SpecialityFilterDropDown.vue')
)

const SponsorAcademicLevelFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/SponsorAcademicLevelFilterDropDown.vue')
)

const SponsorTypeFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/SponsorTypeFilterDropDown.vue')
)

const SponsorsFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/SponsorsFilterDropDown.vue')
)

const TraineeAcademicLevelFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/TraineeAcademicLevelFilterDropDown.vue')
)

const TraineeSpecialityFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/TraineeSpecialityFilterDropDown.vue')
)

const UniversityFilterDropDown = defineAsyncComponent(
    () => import('@/Components/Global/filters/UniversityFilterDropDown.vue')
)

const ZonesFilterDropDown = defineAsyncComponent(() => import('@/Components/Global/filters/ZonesFilterDropDown.vue'))
</script>

<template>
    <suspense v-if="field?.label === 'family'">
        <families-filter-drop-down

            v-model:value="value"
            class="text-sm"
        ></families-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'sponsor'">
        <sponsors-filter-drop-down

            v-model:value="value"
            class="text-sm"
        ></sponsors-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'location'">
        <cities-filter-drop-down

            v-model:value="value"
            class="text-sm"
        ></cities-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense
        v-else-if="field?.label === 'branch_president' || field?.label === 'creator' || field?.label === 'receiver'">
        <members-filter-drop-down

            v-model:value="value"
            class="text-sm"
        ></members-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'orphan'">
        <orphans-filter-drop-down

            v-model:value="value"
            class="text-sm"
        ></orphans-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'branch'">
        <branches-filter-drop-down v-model:value="value" class="text-sm"></branches-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'zone'">
        <zones-filter-drop-down v-model:value="value" class="text-sm"></zones-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'shoes_size'">
        <shoes-size-filter-drop-down v-model:value="value" class="text-sm"></shoes-size-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'pants_size' || field?.label === 'shirt_size'">
        <clothes-size-filter-drop-down v-model:value="value" class="text-sm"></clothes-size-filter-drop-down>
        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'sponsor_academic_level' || field?.label === 'sponsor.academic_level'">
        <sponsor-academic-level-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></sponsor-academic-level-filter-drop-down>
        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'orphan_academic_level' || field?.label === 'orphan.academic_level'">
        <orphan-academic-level-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></orphan-academic-level-filter-drop-down>
        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'college_student_academic_level'">
        <college-academic-level-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></college-academic-level-filter-drop-down>
        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'trainee_student_academic_level'">
        <trainee-academic-level-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></trainee-academic-level-filter-drop-down>
        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'speciality'">
        <speciality-filter-drop-down v-model:value="value" class="text-sm"></speciality-filter-drop-down>
        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'college_speciality'">
        <college-speciality-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></college-speciality-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'trainee_speciality'">
        <trainee-speciality-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></trainee-speciality-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.field === 'eid_al_adha_status'">
        <eid-al-adha-status-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></eid-al-adha-status-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.field === 'status' && field?.label !== 'eid_al_adha_status'">
        <need-status-filter-drop-down v-model:value="value" class="text-sm"></need-status-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'recipient_type'">
        <needable-type-filter-drop-down v-model:value="value" class="text-sm"></needable-type-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'ramadan_basket_category'">
        <ramadan-basket-category-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></ramadan-basket-category-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'institute'">
        <institute-filter-drop-down v-model:value="value" class="text-sm"></institute-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'university'">
        <university-filter-drop-down v-model:value="value" class="text-sm"></university-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'school'">
        <school-filter-drop-down v-model:value="value" class="text-sm"></school-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-else-if="field?.label === 'member_academic_level' || field?.label === 'member.academic_level'">
        <member-academic-level-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></member-academic-level-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-if="field?.label === 'sponsor_type'">
        <sponsor-type-filter-drop-down v-model:value="value" class="text-sm"></sponsor-type-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-if="field?.label === 'gender'">
        <gender-type-filter-drop-down v-model:value="value" class="text-sm"></gender-type-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-if="field?.label === 'furnishings'">
        <furnishings-filter-drop-down v-model="value" class="text-sm"></furnishings-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-if="field?.label === 'finance_type'">
        <finance-type-filter-drop-down v-model:value="value" class="text-sm"></finance-type-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>

    <suspense v-if="field?.label === 'finance_specification'">
        <finance-specification-filter-drop-down
            v-model:value="value"
            class="text-sm"
        ></finance-specification-filter-drop-down>

        <template #fallback>
            <div class="flex h-full items-center justify-center">
                <spinner-loader class="h-5 w-5"></spinner-loader>
            </div>
        </template>
    </suspense>
</template>

<style lang="postcss" scoped></style>
