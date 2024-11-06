<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'
import type {
    CreateFamilyForm,
    CreateFamilyStepOneProps,
    CreateFamilyStepTwoProps,
    InspectorsMembersType
} from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { defineAsyncComponent, type Ref, ref, watch } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import {
    createFamilyFormAttributes,
    createFamilyStepFiveErrorProps,
    createFamilyStepFourErrorProps,
    createFamilyStepOneErrorProps,
    createFamilyStepSixErrorProps,
    createFamilyStepsTitles,
    createFamilyStepThreeErrorProps,
    createFamilyStepTwoErrorProps
} from '@/utils/constants'
import StepLoader from '@/Pages/Tenant/families/create/StepLoader.vue'
import { $t, $tc } from '@/utils/i18n'

const StepOne = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepOne/StepOne.vue'))

const OrphanForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepThree/OrphanForm.vue'))

const TheOrphans = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepThree/TheOrphans.vue'))

const StepTitle = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/StepTitle.vue'))

const IncomeForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepTwo/IncomeForm.vue'))

const SecondSponsorForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepTwo/SecondSponsorForm.vue'))

const SponsorForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepTwo/SponsorForm.vue'))

const SpouseForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepTwo/SpouseForm.vue'))

const TheActions = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/TheActions.vue'))

const FurnishingForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFour/FurnishingForm.vue'))

const HousingForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFour/HousingForm.vue'))

const OtherPropertiesForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFour/OtherPropertiesForm.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

const FamilySponsorShipForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFive/FamilySponsorShipForm.vue'))

const SponsorSponsorShipForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFive/SponsorSponsorShipForm.vue'))

const OrphansSponsorShipForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFive/OrphansSponsorShipForm.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineOptions({
    layout: TheLayout
})

defineProps<{
    members: InspectorsMembersType
}>()

const StepTwo = defineAsyncComponent({
    loader: () => import('@/Pages/Tenant/families/create/stepTwo/StepTwo.vue')
})

const StepThree = defineAsyncComponent({
    loader: () => import('@/Pages/Tenant/families/create/stepThree/StepThree.vue')
})

const StepFour = defineAsyncComponent({
    loader: () => import('@/Pages/Tenant/families/create/stepFour/StepFour.vue')
})

const StepFive = defineAsyncComponent({
    loader: () => import('@/Pages/Tenant/families/create/stepFive/StepFive.vue')
})

const StepSix = defineAsyncComponent({
    loader: () => import('@/Pages/Tenant/families/create/stepSix/StepSix.vue')
})

const currentStep = ref(1)

const totalSteps = 6

const creatingCompleted = ref(false)

const form = useForm('post', route('tenant.families.store'), createFamilyFormAttributes)

const stepOneCompleted = ref<boolean>(false)

const stepTwoCompleted = ref<boolean>(false)

const stepThreeCompleted = ref<boolean>(false)

const stepFourCompleted = ref<boolean>(false)

const stepFiveCompleted = ref<boolean>(false)

const addOrphan = () => {
    form.orphans.push({
        baby_milk_quantity: 0,
        baby_milk_type: '',
        diapers_quantity: 0,
        diapers_type: '',
        gender: 'male',
        income: null,
        academic_level_id: null,
        vocational_training_id: null,
        birth_date: '',
        family_status: '',
        health_status: '',
        last_name: '',
        note: '',
        pants_size: '',
        shirt_size: '',
        shoes_size: '',
        is_unemployed: false,
        is_handicapped: false,
        first_name: ''
    })

    form.orphans_sponsorship.push({
        medical_sponsorship: false,
        private_lessons: false,
        school_bag: false,
        summer_camp: false,
        university_scholarship: false,
        association_trips: false,
        eid_suit: false
    })
}

const removeOrphan = (index: number) => {
    if (index > 0) {
        form.orphans.splice(index, 1)
    }
}

const validating = ref<boolean>(false)

const validateStep = async (errorProps: CreateFamilyStepOneProps[] | CreateFamilyStepTwoProps[], step: Ref) => {
    validating.value = true

    await form.submit({
        onFinish() {
            let errors = []

            errorProps.forEach((prop) => {
                const regex = prop === 'address' ? new RegExp(`^${prop}$`) : new RegExp(prop)

                Object.keys(form.errors).forEach((error) => {
                    if (regex.test(error)) {

                        errors.push(form.errors[error as keyof CreateFamilyForm])
                    }
                })
            })

            step.value = errors.length === 0 && !form.validating

            validating.value = false
        }
    })
}

const nextStep = async () => {
    if (currentStep.value < totalSteps) {
        await goTo(currentStep.value + 1)
    }
}

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--
    }
}

const forgetErrors = (errors: string[]) => {
    errors.forEach((prop: CreateFamilyStepTwoProps) => {
        const regex = prop === 'address' ? new RegExp(`^${prop}$`) : new RegExp(prop)

        Object.keys(form.errors).forEach((error) => {
            if (regex.test(error)) {
                form.forgetError(error as keyof CreateFamilyForm)
            }
        })

    })
}

const goTo = async (index: number) => {
    if (index <= currentStep.value) {
        currentStep.value = index
    } else {
        if (index === 2) {
            await validateStep(createFamilyStepOneErrorProps, stepOneCompleted).finally(() => {
                forgetErrors(createFamilyStepTwoErrorProps)

                if (stepOneCompleted.value) currentStep.value = 2
            })
        }

        if (index === 3) {
            await validateStep(createFamilyStepTwoErrorProps, stepTwoCompleted).finally(() => {
                if (stepOneCompleted.value && stepTwoCompleted.value) {
                    forgetErrors(createFamilyStepThreeErrorProps)

                    currentStep.value = 3
                }
            })
        }

        if (index === 4) {
            await validateStep(createFamilyStepThreeErrorProps, stepThreeCompleted).finally(() => {
                if (stepOneCompleted.value && stepTwoCompleted.value && stepThreeCompleted.value) {
                    forgetErrors(createFamilyStepFourErrorProps)

                    currentStep.value = 4
                }
            })
        }

        if (index === 5) {
            await validateStep(createFamilyStepFourErrorProps, stepFourCompleted).finally(() => {
                if (stepOneCompleted.value && stepTwoCompleted.value && stepThreeCompleted.value && stepFourCompleted.value) {
                    forgetErrors(createFamilyStepFiveErrorProps)

                    currentStep.value = 5
                }
            })
        }

        if (index === 6) {
            await validateStep(createFamilyStepFiveErrorProps, stepFiveCompleted).finally(() => {
                if (stepOneCompleted.value && stepTwoCompleted.value && stepThreeCompleted.value && stepFourCompleted.value && stepFiveCompleted.value) {
                    forgetErrors(createFamilyStepSixErrorProps)

                    currentStep.value = 6
                }
            })
        }
    }
}

watch(() => currentStep.value, () => {
    form.submitted = currentStep.value === 6
})

const submit = () => {
    validating.value = true

    form.submit({
        onSuccess() {
            creatingCompleted.value = true

            setTimeout(() => {
                router.visit(route('tenant.families.index'))
            }, 2000)
        },
        onFinish() {
            validating.value = false
        }
    })
}
</script>

<template>
    <Head :title="$tc('add new',0,{attribute:$t('family')})"></Head>

    <div>
        <div class="mx-auto flex-col content-center py-5">
            <div class="intro-y box py-10">
                <div
                    class="relative flex flex-col justify-center px-5 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[70%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block"
                >
                    <step-title
                        v-for="(title, index) in createFamilyStepsTitles"
                        :key="`step-${index}`"
                        :current-step="currentStep"
                        :index="index + 1"
                        :title="title"
                        @go-to="goTo"
                    ></step-title>
                </div>

                <form @submit.prevent="submit">
                    <step-one
                        v-model:address="form.address"
                        v-model:branch="form.branch_id"
                        v-model:file-number="form.file_number"
                        v-model:location="form.location"
                        v-model:start-date="form.start_date"
                        v-model:zone="form.zone_id"
                        :currentStep
                        :form
                        :totalSteps
                    >
                        <the-actions :currentStep :nextStep :prevStep :totalSteps
                                     :validating></the-actions>
                    </step-one>

                    <Suspense v-if="currentStep === 2">
                        <template #default>
                            <step-two :currentStep :form :totalSteps>
                                <template #sponsorForm>
                                    <sponsor-form
                                        v-model:academic_level="form.sponsor.academic_level_id"
                                        v-model:birth_certificate_number="form.sponsor.birth_certificate_number"
                                        v-model:birth_date="form.sponsor.birth_date"
                                        v-model:card_number="form.sponsor.card_number"
                                        v-model:ccp="form.sponsor.ccp"
                                        v-model:diploma="form.sponsor.diploma"
                                        v-model:father_name="form.sponsor.father_name"
                                        v-model:first_name="form.sponsor.first_name"
                                        v-model:function="form.sponsor.function"
                                        v-model:health_status="form.sponsor.health_status"
                                        v-model:is-unemployed="form.sponsor.is_unemployed"
                                        v-model:last_name="form.sponsor.last_name"
                                        v-model:mother_name="form.sponsor.mother_name"
                                        v-model:phone="form.sponsor.phone_number"
                                        v-model:sponsor-type="form.sponsor.sponsor_type"
                                        :form
                                    ></sponsor-form>
                                </template>

                                <template #incomeForm>
                                    <income-form
                                        v-model:account="form.incomes.account"
                                        v-model:casnos="form.incomes.casnos"
                                        v-model:cnas="form.incomes.cnas"
                                        v-model:cnr="form.incomes.cnr"
                                        v-model:other_income="form.incomes.other_income"
                                        v-model:pension="form.incomes.pension"
                                        :form
                                    ></income-form>
                                </template>

                                <template #secondSponsorForm>
                                    <second-sponsor-form
                                        v-model:address="form.second_sponsor.address"
                                        v-model:degree_of_kinship="form.second_sponsor.degree_of_kinship"
                                        v-model:first_name="form.second_sponsor.first_name"
                                        v-model:income="form.second_sponsor.income"
                                        v-model:last_name="form.second_sponsor.last_name"
                                        v-model:phone="form.second_sponsor.phone_number"
                                        v-model:with-family="form.second_sponsor.with_family"
                                        :form
                                    ></second-sponsor-form>
                                </template>

                                <template #spouseForm>
                                    <spouse-form
                                        v-model:birth-date="form.spouse.birth_date"
                                        v-model:death-date="form.spouse.death_date"
                                        v-model:first_name="form.spouse.first_name"
                                        v-model:income="form.spouse.income"
                                        v-model:job="form.spouse.function"
                                        v-model:last_name="form.spouse.last_name"
                                        :form
                                    ></spouse-form>
                                </template>
                                <the-actions :currentStep :nextStep :prevStep :totalSteps :validating></the-actions>
                            </step-two>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </Suspense>

                    <Suspense v-if="currentStep === 3">
                        <template #default>
                            <step-three :currentStep :totalSteps>
                                <template #orphansForm>
                                    <template v-for="(orphan, index) in form.orphans" :key="`orphan-${index}`">
                                        <the-orphans :index @remove-orphan="removeOrphan">
                                            <orphan-form
                                                v-model:academic-level="orphan.academic_level_id"
                                                v-model:baby-milk-quantity="orphan.baby_milk_quantity"
                                                v-model:baby-milk-type="orphan.baby_milk_type"
                                                v-model:birth_date="orphan.birth_date"
                                                v-model:diapers-quantity="orphan.diapers_quantity"
                                                v-model:diapers-type="orphan.diapers_type"
                                                v-model:family_status="orphan.family_status"
                                                v-model:first_name="orphan.first_name"
                                                v-model:gender="orphan.gender"
                                                v-model:health_status="orphan.health_status"
                                                v-model:income="orphan.income"
                                                v-model:is-handicapped="orphan.is_handicapped"
                                                v-model:is-unemployed="orphan.is_unemployed"
                                                v-model:last_name="orphan.last_name"
                                                v-model:note="orphan.note"
                                                v-model:pants-size="orphan.pants_size"
                                                v-model:shirt-size="orphan.shirt_size"
                                                v-model:shoes-size="orphan.shoes_size"
                                                v-model:vocational_training="orphan.vocational_training_id"

                                                :form
                                                :index
                                            ></orphan-form>
                                        </the-orphans>
                                    </template>

                                    <base-button
                                        class="mx-auto mt-4 block w-1/2 border-dashed dark:text-slate-500"
                                        data-test="add_orphan"
                                        type="button"
                                        variant="outline-primary"
                                        @click="addOrphan"
                                    >
                                        <svg-loader class="inline fill-primary dark:fill-slate-500"
                                                    name="icon-plus"></svg-loader>

                                        {{ $t('add_new_orphan') }}
                                    </base-button>
                                </template>

                                <the-actions :currentStep :nextStep :prevStep :totalSteps :validating></the-actions>
                            </step-three>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </Suspense>

                    <Suspense v-if="currentStep === 4">
                        <template #default>
                            <step-four :currentStep :form :totalSteps>
                                <template #housingForm>
                                    <housing-form
                                        v-model:housing-receipt-number="form.housing.housing_receipt_number"
                                        v-model:housing-type="form.housing.housing_type"
                                        v-model:number-of-rooms="form.housing.number_of_rooms"
                                        :form
                                    ></housing-form>
                                </template>

                                <template #furnishingForm>
                                    <furnishing-form :form
                                                     @update:furnishings="form.furnishings = {...$event}"></furnishing-form>
                                </template>

                                <template #otherPropertiesForm>
                                    <other-properties-form v-model:other-properties="form.other_properties"
                                                           :form></other-properties-form>
                                </template>

                                <the-actions :currentStep :nextStep :prevStep :totalSteps :validating></the-actions>
                            </step-four>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </Suspense>

                    <Suspense v-if="currentStep === 5">
                        <template #default>
                            <step-five :currentStep :form :totalSteps>
                                <template #FamilySponsorShipForm>
                                    <family-sponsor-ship-form
                                        v-model:eid-al-adha="form.family_sponsorship.eid_al_adha"
                                        v-model:housing-assistance="form.family_sponsorship.housing_assistance"
                                        v-model:monthly-allowance="form.family_sponsorship.monthly_allowance"
                                        v-model:ramadan-basket="form.family_sponsorship.ramadan_basket"
                                        v-model:zakat="form.family_sponsorship.zakat"
                                    ></family-sponsor-ship-form>
                                </template>

                                <template #SponsorSponsorShipForm>
                                    <sponsor-sponsor-ship-form
                                        v-model:direct-sponsorship="form.sponsor_sponsorship.direct_sponsorship"
                                        v-model:literacy-lessons="form.sponsor_sponsorship.literacy_lessons"
                                        v-model:medical-sponsorship="form.sponsor_sponsorship.medical_sponsorship"
                                        v-model:project-support="form.sponsor_sponsorship.project_support"
                                    ></sponsor-sponsor-ship-form>
                                </template>

                                <template #OrphansSponsorShipForm>
                                    <template v-for="(orphanSponsorship,index) in form.orphans_sponsorship"
                                              :key="`orphan-${index}`">
                                        <orphans-sponsor-ship-form
                                            :form :index
                                            @update:orphans-sponsorship="form.orphans_sponsorship[index] = {...$event}"></orphans-sponsor-ship-form>
                                    </template>
                                </template>

                                <the-actions :currentStep :nextStep :prevStep :totalSteps :validating></the-actions>
                            </step-five>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </Suspense>

                    <Suspense v-if="currentStep === 6">
                        <template #default>
                            <step-six v-model:inspectors-members="form.inspectors_members"
                                      v-model:preview-date="form.preview_date"
                                      v-model:report="form.report" :currentStep
                                      :form
                                      :members
                                      :totalSteps>
                                <the-actions :currentStep :nextStep="submit" :prevStep :totalSteps
                                             :validating></the-actions>
                            </step-six>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </Suspense>
                </form>
            </div>
        </div>

        <success-notification
            :open="creatingCompleted"
            :options="{ duration: 1500}"
            :title="$t('successfully_created',{attribute: $t('the_family') })"
        ></success-notification>
    </div>
</template>
