<script lang="ts" setup>
import type { SponsorUpdateFormType } from '@/types/sponsors'

import { useCreateFamilyStore } from '@/stores/create-family'
import { useForm } from 'laravel-precognition-vue'
import { onUnmounted, reactive, ref, watch } from 'vue'

import IncomeForm from '@/Pages/Tenant/families/create/stepTwo/IncomeForm.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { omit } from '@/utils/helper'

const props = defineProps<{ sponsor: SponsorUpdateFormType }>()

const inputs = reactive({ incomes: omit(props.sponsor.incomes, ['id', 'total_income']) })

const form = useForm<SponsorUpdateFormType>('put', route('tenant.sponsors.incomes-update', props.sponsor.id), inputs)

const updateSuccess = ref(false)

const createFamilyStore = useCreateFamilyStore()

createFamilyStore.family.incomes = props.sponsor.incomes

watch(
    () => createFamilyStore.family.incomes,
    (value) => {
        form.setData(value)
    },
    { deep: true }
)

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

onUnmounted(() => {
    createFamilyStore.$reset()
})
</script>

<template>
    <!-- BEGIN: Incomes -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('income information') }}</h2>
        </div>

        <form @submit.prevent="submit">
            <div class="p-5">
                <income-form :form></income-form>

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
