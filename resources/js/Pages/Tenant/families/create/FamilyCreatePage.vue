<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'
import type { CreateFamilyForm, InspectorsMembersType } from '@/types/types'

import { useForm } from 'laravel-precognition-vue'
import { defineAsyncComponent, nextTick, onMounted, onUnmounted, ref, watch } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'
import { createFamilyStepsTitles } from '@/utils/constants'
import StepLoader from '@/Pages/Tenant/families/create/StepLoader.vue'
import { $t, $tc } from '@/utils/i18n'
import { useCreateFamilyStore } from '@/stores/create-family'

defineOptions({
    layout: TheLayout
})

defineProps<{
    members: InspectorsMembersType
}>()

const StepOne = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepOne/StepOne.vue'))

const StepTitle = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/StepTitle.vue'))

const TheActions = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/TheActions.vue'))

const FurnishingForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFour/FurnishingForm.vue'))

const HousingForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFour/HousingForm.vue'))

const OtherPropertiesForm = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFour/OtherPropertiesForm.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

const StepTwo = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepTwo/StepTwo.vue'))

const StepThree = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepThree/StepThree.vue'))

const StepFour = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFour/StepFour.vue'))

const StepFive = defineAsyncComponent(() => import('@/Pages/Tenant/families/create/stepFive/StepFive.vue'))

const createFamilyStore = useCreateFamilyStore()

const form = useForm('post', route('tenant.families.store'), createFamilyStore.family as CreateFamilyForm)

const mustValidateNavigation = ref(true)

const nextStep = async () => {
    createFamilyStore.is_dirty = true

    document.getElementById('create-family-form')?.scrollIntoView({
        behavior: 'smooth'
    })

    if (createFamilyStore.current_step < createFamilyStore.total_steps) {
        await goTo(createFamilyStore.current_step + 1)
    }
}

const prevStep = () => {
    createFamilyStore.is_dirty = true

    if (createFamilyStore.current_step === 1) return

    document.getElementById('create-family-form')?.scrollIntoView({
        behavior: 'smooth'
    })

    const stepChanges = [
        { step: 2, tabIndex: -1, newStep: 1 },
        { step: 3, tabIndex: 3, newStep: 2 },
        { step: 4, tabIndex: -1, newStep: 3 },
        { step: 5, tabIndex: 2, newStep: 4 }
    ]

    const currentStep = createFamilyStore.current_step

    const stepChange = stepChanges.find((s) => s.step === currentStep)

    if (stepChange) {
        if (stepChange.tabIndex === -1) {
            createFamilyStore.tab_index--
        } else {
            createFamilyStore.tab_index = stepChange.tabIndex
        }

        createFamilyStore.current_step = stepChange.newStep
    }
}

const navigate = async (index: number) => {
    createFamilyStore.is_dirty = true

    if (index < createFamilyStore.current_step) {
        createFamilyStore.current_step = index
    } else {
        if (mustValidateNavigation.value) {
            await goTo(index).finally(() => {
                mustValidateNavigation.value = false

                createFamilyStore.handleClickToNextStep(form, index)
            })
        } else {
            createFamilyStore.handleClickToNextStep(form, index)
        }
    }
}

const goTo = async (index: number) => {
    if (index <= createFamilyStore.current_step) {
        createFamilyStore.current_step = index
    } else {
        if (index === 2) {
            await createFamilyStore.validateStepOne(form)
        }

        if (index === 3) {
            await createFamilyStore.validateStepTwo(form)
        }

        if (index === 4) {
            await createFamilyStore.validateStepThree(form)
        }

        if (index === 5) {
            await createFamilyStore.validateStepFour(form)
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
            return true
        } else if (createFamilyStore.is_dirty) {
            if (!confirm($t('unsaved_changes_warning'))) {
                event.preventDefault()

                return false
            } else {
                return true
            }
        }
    })
})

onUnmounted(() => {
    createFamilyStore.$reset()

    createFamilyStore.is_dirty = false
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
                        @go-to="navigate($event)"
                    ></step-title>
                </div>

                <form @submit.prevent="submit">
                    <suspense v-if="createFamilyStore.current_step === 1">
                        <step-one :form>
                            <the-actions :nextStep="nextStep" :prevStep="prevStep"></the-actions>
                        </step-one>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>

                    <suspense v-if="createFamilyStore.current_step === 2">
                        <step-two :form>
                            <the-actions :nextStep="nextStep" :prevStep="prevStep"></the-actions>
                        </step-two>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>

                    <suspense v-if="createFamilyStore.current_step === 3">
                        <step-three :form>
                            <the-actions :nextStep="nextStep" :prevStep="prevStep"></the-actions>
                        </step-three>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>

                    <suspense v-if="createFamilyStore.current_step === 4">
                        <template #default>
                            <step-four :form>
                                <template #housingForm>
                                    <housing-form :form></housing-form>
                                </template>

                                <template #furnishingForm>
                                    <furnishing-form :form></furnishing-form>
                                </template>

                                <template #otherPropertiesForm>
                                    <other-properties-form :form></other-properties-form>
                                </template>

                                <the-actions :nextStep="nextStep" :prevStep="prevStep"></the-actions>
                            </step-four>
                        </template>

                        <template #fallback>
                            <step-loader></step-loader>
                        </template>
                    </suspense>

                    <suspense v-if="createFamilyStore.current_step === 5">
                        <step-five :form :members>
                            <the-actions :nextStep="submit" :prevStep></the-actions>
                        </step-five>

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
