<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'
import type {
    CreateFamilyForm,
    CreateFamilyStepOneProps,
    CreateFamilyStepTwoProps,
    InspectorsMembersType
} from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { defineAsyncComponent, nextTick, onMounted, type Ref, ref, watch } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import {
    createFamilyStepFiveErrorProps,
    createFamilyStepFourErrorProps,
    createFamilyStepOneErrorProps,
    createFamilyStepsTitles,
    createFamilyStepThreeErrorProps,
    createFamilyStepTwoErrorProps
} from '@/utils/constants'
import StepLoader from '@/Pages/Tenant/families/create/StepLoader.vue'
import { $t, $tc } from '@/utils/i18n'
import { useCreateFamilyStore } from '@/stores/create-family'
import { checkErrors } from '@/utils/helper'

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

const createFamilyStore = useCreateFamilyStore()

const currentStep = ref(createFamilyStore.current_step)

const totalSteps = ref(createFamilyStore.total_steps)

const creatingCompleted = ref(createFamilyStore.creatingCompleted)

const form = useForm('post', route('tenant.families.store'), createFamilyStore.family as CreateFamilyForm)

const validating = ref<boolean>(false)

const isDirty = ref<boolean>(false)

const stepOneCompleted = ref<boolean>(createFamilyStore.step_one_completed)

const stepTwoCompleted = ref<boolean>(createFamilyStore.step_two_completed)

const stepThreeCompleted = ref<boolean>(createFamilyStore.step_three_completed)

const stepFourCompleted = ref<boolean>(createFamilyStore.step_four_completed)

const selectedTabStepTwo = ref(createFamilyStore.current_step === 2 ? createFamilyStore.tab_index : 0)

const selectedTabStepFour = ref(createFamilyStore.current_step === 4 ? createFamilyStore.tab_index : 0)


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
}

const removeOrphan = (index: number) => {
    if (index > 0) {
        form.orphans.splice(index, 1)
    }
}

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
    document.body.scrollIntoView({
        block: 'start',
        behavior: 'smooth'
    })

    if (currentStep.value < totalSteps.value) {
        await goTo(currentStep.value + 1).finally(() => {
            updateState(form.data())
        })
    }
}

const prevStep = () => {
    if (currentStep.value === 1) {
        return
    }

    document.body.scrollIntoView({
        block: 'start',
        behavior: 'smooth'
    })

    if (currentStep.value === 2) {
        if (selectedTabStepTwo.value === 0) {
            currentStep.value = 1
        } else {
            selectedTabStepTwo.value--
        }
    }

    if (currentStep.value === 3) {
        currentStep.value = 2

        selectedTabStepTwo.value = 3
    }

    if (currentStep.value === 4) {
        if (selectedTabStepFour.value === 0) {
            currentStep.value = 3
        } else {
            selectedTabStepFour.value--
        }
    }

    if (currentStep.value === 5) {
        currentStep.value = 4

        selectedTabStepFour.value = 2
    }

    updateState(form.data())
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
            stepOneCompleted.value = false

            await validateStep(createFamilyStepOneErrorProps, stepOneCompleted).finally(() => {
                forgetErrors(createFamilyStepTwoErrorProps)

                if (stepOneCompleted.value) currentStep.value = 2
            })
        }

        if (index === 3) {
            stepTwoCompleted.value = false

            if (stepOneCompleted.value) {
                currentStep.value = 2
            }

            await validateStep(createFamilyStepTwoErrorProps, stepTwoCompleted).finally(() => {

                if (stepOneCompleted.value && stepTwoCompleted.value && selectedTabStepTwo.value === 3) {
                    forgetErrors(createFamilyStepThreeErrorProps)

                    currentStep.value = 3
                } else if (selectedTabStepTwo.value === 0 && !checkErrors('^sponsor.+', form.errors)) {
                    selectedTabStepTwo.value = 1
                } else if (selectedTabStepTwo.value === 1 && !checkErrors('^income', form.errors)) {
                    selectedTabStepTwo.value = 2
                } else if (selectedTabStepTwo.value === 2 && !checkErrors('^second_sponsor', form.errors)) {
                    selectedTabStepTwo.value = 3
                } else if (selectedTabStepTwo.value === 3 && !checkErrors('^spouse', form.errors) && !checkErrors('^second_sponsor', form.errors) && !checkErrors('^sponsor.+', form.errors) && !checkErrors('^income', form.errors)) {
                    currentStep.value = 3
                }
            })
        }

        if (index === 4) {
            await validateStep(createFamilyStepThreeErrorProps, stepThreeCompleted).finally(() => {
                if (stepOneCompleted.value && stepTwoCompleted.value && stepThreeCompleted.value) {
                    forgetErrors(createFamilyStepFourErrorProps)

                    currentStep.value = 4

                    selectedTabStepFour.value = 0
                }
            })
        }

        if (index === 5) {
            await validateStep(createFamilyStepFourErrorProps, stepFourCompleted).finally(() => {
                if (stepOneCompleted.value && stepTwoCompleted.value && stepThreeCompleted.value && stepFourCompleted.value && selectedTabStepFour.value === 2) {
                    forgetErrors(createFamilyStepFiveErrorProps)

                    currentStep.value = 5
                } else if (selectedTabStepFour.value === 0 && !checkErrors('^housing', form.errors)) {
                    selectedTabStepFour.value = 1
                } else if (selectedTabStepFour.value === 1 && !checkErrors('^furnishings', form.errors)) {
                    selectedTabStepFour.value = 2
                } else if (selectedTabStepFour.value === 3 && !checkErrors('^housing', form.errors) && !checkErrors('^furnishings', form.errors) && !checkErrors('other_properties$', form.errors)) {
                    currentStep.value = 5
                }
            })
        }
    }
}

const updateState = (data: object) => {
    createFamilyStore.$patch((state) => {
        state.family = data

        state.current_step = currentStep.value

        if (currentStep.value === 2) {
            state.tab_index = selectedTabStepTwo.value
        } else if (currentStep.value === 4) {
            state.tab_index = selectedTabStepFour.value
        } else {
            state.tab_index = 0
        }

        state.step_one_completed = stepOneCompleted.value

        state.step_two_completed = stepTwoCompleted.value

        state.step_three_completed = stepThreeCompleted.value

        state.step_four_completed = stepFourCompleted.value

        state.creating_completed = creatingCompleted.value
    })

    isDirty.value = true
}

const submit = () => {
    validating.value = true

    form.submit({

        onSuccess() {
            creatingCompleted.value = true

            createFamilyStore.creating_completed = true

            nextTick(() => {
                setTimeout(() => {
                    router.visit(route('tenant.families.index'))
                }, 500)
            })
        },
        onFinish() {
            validating.value = false
        }
    })
}

const handleTabChange = (index, step) => {
    if (step === 2) {
        selectedTabStepTwo.value = index

        createFamilyStore.$patch((state) => {
            state.tab_index = index
        })
    }

    if (step === 4) {
        selectedTabStepFour.value = index

        createFamilyStore.$patch((state) => {
            state.tab_index = index
        })
    }
}

const handleNavigation = (event: Event) => {
    if (event.detail.visit.url.pathname === '/dashboard/families/create') {
        return true
    }

    if (creatingCompleted.value) {
        createFamilyStore.$reset()

        isDirty.value = false

        return true
    } else if (isDirty.value) {
        if (!confirm($t('unsaved_changes_warning'))) {
            event.preventDefault()

            return false
        } else {
            createFamilyStore.$reset()

            isDirty.value = false

            return true
        }
    }
}

watch(() => currentStep.value, () => {
    form.submitted = createFamilyStore.family.submitted = currentStep.value === 5
})

watch(() => form, (value) => {
    updateState(value.data())
}, { deep: true })

onMounted(() => {
    router.on('before', handleNavigation)
})
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
                        @go-to="($event)=>{
                            // goToClicked=true
                            goTo($event)
                        }"
                    ></step-title>
                </div>

                <form @submit.prevent="submit">
                    <step-one
                        v-model:address="form.address"
                        v-model:branch="form.branch_id"
                        v-model:file-number="form.file_number"
                        v-model:location="form.location"
                        v-model:residence-certificate-file="form.residence_certificate_file"
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
                            <step-two :currentStep :form :selectedIndex="selectedTabStepTwo"
                                      :totalSteps @changeTab="handleTabChange($event, 2)">
                                <template #sponsorForm>
                                    <sponsor-form
                                        v-model:academic_level="form.sponsor.academic_level_id"
                                        v-model:birth-certificate-file="form.sponsor.birth_certificate_file"
                                        v-model:birth_certificate_number="form.sponsor.birth_certificate_number"
                                        v-model:birth_date="form.sponsor.birth_date"
                                        v-model:card_number="form.sponsor.card_number"
                                        v-model:ccp="form.sponsor.ccp"
                                        v-model:diploma="form.sponsor.diploma"
                                        v-model:diploma-file="form.sponsor.diploma_file"
                                        v-model:father_name="form.sponsor.father_name"
                                        v-model:first_name="form.sponsor.first_name"
                                        v-model:function="form.sponsor.function"
                                        v-model:health_status="form.sponsor.health_status"
                                        v-model:is-unemployed="form.sponsor.is_unemployed"
                                        v-model:last_name="form.sponsor.last_name"
                                        v-model:mother_name="form.sponsor.mother_name"
                                        v-model:phone="form.sponsor.phone_number"
                                        v-model:photo="form.sponsor.photo"
                                        v-model:sponsor-type="form.sponsor.sponsor_type"
                                        :form
                                    ></sponsor-form>
                                </template>

                                <template #incomeForm>
                                    <income-form
                                        v-model:account="form.incomes.account"
                                        v-model:bank-file="form.incomes.bank_file"
                                        v-model:casnos="form.incomes.casnos"
                                        v-model:casnos-file="form.incomes.casnos_file"
                                        v-model:ccp-file="form.incomes.ccp_file"
                                        v-model:cnas="form.incomes.cnas"
                                        v-model:cnas-file="form.incomes.cnas_file"
                                        v-model:cnr="form.incomes.cnr"
                                        v-model:cnr-file="form.incomes.cnr_file"
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
                                        v-model:death-certificate-file="form.spouse.death_certificate_file"
                                        v-model:death-date="form.spouse.death_date"
                                        v-model:first_name="form.spouse.first_name"
                                        v-model:income="form.spouse.income"
                                        v-model:job="form.spouse.function"
                                        v-model:last_name="form.spouse.last_name"
                                        :form
                                    ></spouse-form>
                                </template>

                                <the-actions :currentStep :nextStep :prevStep :totalSteps
                                             :validating></the-actions>
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
                                                v-model:photo="orphan.photo"
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
                            <step-four :currentStep
                                       :form :selectedIndex="selectedTabStepFour" :totalSteps
                                       @changeTab="handleTabChange($event, 4)">
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
                            <step-five v-model:inspectors-members="form.inspectors_members"
                                       v-model:preview-date="form.preview_date"
                                       v-model:report="form.report" :currentStep
                                       :form
                                       :members
                                       :totalSteps>
                                <the-actions :currentStep :nextStep="submit" :prevStep :totalSteps
                                             :validating></the-actions>
                            </step-five>
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
            :options="{ duration: 2500}"
            :title="$t('successfully_created',{attribute: $t('the_family') })"
        ></success-notification>
    </div>
</template>
