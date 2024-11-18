<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'
import type {
    CreateFamilyForm,
    CreateFamilyStepOneProps,
    CreateFamilyStepTwoProps,
    InspectorsMembersType
} from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { defineAsyncComponent, nextTick, onMounted, watch } from 'vue'

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

defineOptions({
    layout: TheLayout
})

defineProps<{
    members: InspectorsMembersType
}>()

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

const form = useForm('post', route('tenant.families.store'), createFamilyStore.family as CreateFamilyForm)

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

const validateStep = async (errorProps: CreateFamilyStepOneProps[] | CreateFamilyStepTwoProps[], step: string) => {
    createFamilyStore.validating = true

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

            createFamilyStore[step] = errors.length === 0 && !form.validating

            createFamilyStore.validating = false
        }
    })
}

const nextStep = async () => {
    document.getElementById('create-family-form')?.scrollIntoView({
        behavior: 'smooth'
    })

    if (createFamilyStore.current_step < createFamilyStore.total_steps) {
        await goTo(createFamilyStore.current_step + 1)
    }
}

const prevStep = () => {
    if (createFamilyStore.current_step === 1) return;

    document.getElementById('create-family-form')?.scrollIntoView({
        behavior: 'smooth',
    });

    const stepChanges = [
        { step: 2, tabIndex: -1, newStep: 1 },
        { step: 3, tabIndex: 3, newStep: 2 },
        { step: 4, tabIndex: -1, newStep: 3 },
        { step: 5, tabIndex: 2, newStep: 4 },
    ];

    const currentStep = createFamilyStore.current_step;

    const stepChange = stepChanges.find((s) => s.step === currentStep);

    if (stepChange) {
        if (stepChange.tabIndex === -1) {
            createFamilyStore.tab_index--;
        } else {
            createFamilyStore.tab_index = stepChange.tabIndex;
        }

        createFamilyStore.current_step = stepChange.newStep;
    }
};

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
    if (index <= createFamilyStore.current_step) {
        createFamilyStore.current_step = index
    } else {
        if (index === 2) {
            createFamilyStore.step_one_completed = false

            await validateStep(createFamilyStepOneErrorProps, 'step_one_completed').finally(() => {
                forgetErrors(createFamilyStepTwoErrorProps)

                if (createFamilyStore.step_one_completed) createFamilyStore.current_step = 2
            })
        }

        if (index === 3) {
            createFamilyStore.step_two_completed = false

            if (createFamilyStore.step_one_completed) {
                createFamilyStore.current_step = 2
            }

            await validateStep(createFamilyStepTwoErrorProps, 'step_two_completed').finally(() => {

                if (createFamilyStore.step_one_completed && createFamilyStore.step_two_completed && createFamilyStore.tab_index === 3) {
                    forgetErrors(createFamilyStepThreeErrorProps)

                    createFamilyStore.current_step = 3
                } else if (createFamilyStore.tab_index === 0 && !checkErrors('^sponsor.+', form.errors)) {
                    createFamilyStore.tab_index = 1
                } else if (createFamilyStore.tab_index === 1 && !checkErrors('^income', form.errors)) {
                    createFamilyStore.tab_index = 2
                } else if (createFamilyStore.tab_index === 2 && !checkErrors('^second_sponsor', form.errors)) {
                    createFamilyStore.tab_index = 3
                } else if (createFamilyStore.tab_index === 3 && !checkErrors('^spouse', form.errors) && !checkErrors('^second_sponsor', form.errors) && !checkErrors('^sponsor.+', form.errors) && !checkErrors('^income', form.errors)) {
                    createFamilyStore.current_step = 3
                }
            })
        }

        if (index === 4) {
            await validateStep(createFamilyStepThreeErrorProps, 'step_three_completed').finally(() => {
                if (createFamilyStore.step_one_completed && createFamilyStore.step_two_completed && createFamilyStore.step_three_completed) {
                    forgetErrors(createFamilyStepFourErrorProps)

                    createFamilyStore.current_step = 4

                    createFamilyStore.tab_index = 0
                }
            })
        }

        if (index === 5) {
            await validateStep(createFamilyStepFourErrorProps, 'step_four_completed').finally(() => {
                if (createFamilyStore.step_one_completed && createFamilyStore.step_two_completed && createFamilyStore.step_three_completed && createFamilyStore.step_four_completed && createFamilyStore.tab_index === 2) {
                    forgetErrors(createFamilyStepFiveErrorProps)

                    createFamilyStore.current_step = 5
                } else if (createFamilyStore.tab_index === 0 && !checkErrors('^housing', form.errors)) {
                    createFamilyStore.tab_index = 1
                } else if (createFamilyStore.tab_index === 1 && !checkErrors('^furnishings', form.errors)) {
                    createFamilyStore.tab_index = 2
                } else if (createFamilyStore.tab_index === 3 && !checkErrors('^housing', form.errors) && !checkErrors('^furnishings', form.errors) && !checkErrors('other_properties$', form.errors)) {
                    createFamilyStore.current_step = 5
                }
            })
        }
    }
}

const submit = () => {
    createFamilyStore.validating = true

    form.submit({

        onSuccess() {
            createFamilyStore.creating_completed = true

            nextTick(() => {
                setTimeout(() => {
                    router.visit(route('tenant.families.index'))
                }, 500)
            })
        },
        onFinish() {
            createFamilyStore.validating = false
        }
    })
}

watch(() => createFamilyStore.current_step, () => {
    form.submitted = createFamilyStore.family.submitted = createFamilyStore.current_step === 5
})

watch(() => createFamilyStore.family, (value) => {
    form.setData(value)
}, { deep: true })

onMounted(() => {
    router.on('before', (event: Event) => {
        if (event.detail.visit.url.pathname === '/dashboard/families/create') {
            return true
        }

        if (createFamilyStore.creating_completed) {
            createFamilyStore.$reset()

            return true
        } else if (createFamilyStore.is_dirty) {
            if (!confirm($t('unsaved_changes_warning'))) {
                event.preventDefault()

                return false
            } else {
                createFamilyStore.$reset()

                return true
            }
        }
    })
})
</script>

<template>
    <Head :title="$tc('add new',0,{attribute:$t('family')})"></Head>

    <div>
        <div class="mx-auto flex-col content-center py-5">
            <div class="intro-y box py-10">
                <div id="create-family-form"
                     class="relative flex flex-col justify-center px-5 before:absolute before:bottom-0 before:top-0 before:mt-4 before:hidden before:h-[3px] before:w-[70%] before:bg-slate-100 before:dark:bg-darkmode-400 sm:px-20 lg:flex-row before:lg:block"
                >
                    <step-title
                        v-for="(title, index) in createFamilyStepsTitles"
                        :key="`step-${index}`"
                        :index="index + 1"
                        :title="title"
                        @go-to="goTo($event)"
                    ></step-title>
                </div>

                <form @submit.prevent="submit">
                    <step-one :form>
                        <the-actions :nextStep :prevStep></the-actions>
                    </step-one>

                    <suspense v-if="createFamilyStore.current_step === 2">
                        <template #default>
                            <step-two :form>
                                <template #sponsorForm>
                                    <sponsor-form :form
                                    ></sponsor-form>
                                </template>

                                <template #incomeForm>
                                    <income-form :form
                                    ></income-form>
                                </template>

                                <template #secondSponsorForm>
                                    <second-sponsor-form :form
                                    ></second-sponsor-form>
                                </template>

                                <template #spouseForm>
                                    <spouse-form :form
                                    ></spouse-form>
                                </template>

                                <the-actions :nextStep :prevStep></the-actions>
                            </step-two>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>

                    <suspense v-if="createFamilyStore.current_step === 3">
                        <template #default>
                            <step-three>
                                <template #orphansForm>
                                    <template v-for="(orphan, index) in form.orphans" :key="`orphan-${index}`">
                                        <the-orphans :index @remove-orphan="removeOrphan">
                                            <orphan-form :form :index></orphan-form>
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

                                <the-actions :nextStep :prevStep></the-actions>
                            </step-three>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>

                    <suspense v-if="createFamilyStore.current_step === 4">
                        <template #default>
                            <step-four :form>
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

                                <the-actions :nextStep :prevStep></the-actions>
                            </step-four>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>

                    <suspense v-if="createFamilyStore.current_step === 5">
                        <template #default>
                            <step-five :form :members>
                                <the-actions :nextStep="submit" :prevStep></the-actions>
                            </step-five>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>
                </form>
            </div>
        </div>

        <success-notification
            :open="createFamilyStore.creating_completed"
            :options="{ duration: 2500}"
            :title="$t('successfully_created',{attribute: $t('the_family') })"
        ></success-notification>
    </div>
</template>
