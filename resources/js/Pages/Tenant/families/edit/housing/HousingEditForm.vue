<script lang="ts" setup>
import type { FamilyEditHousingType, FamilyUpdateHousingFormType } from '@/types/families'

import { useCreateFamilyStore } from '@/stores/create-family'
import { useForm } from 'laravel-precognition-vue'
import { onUnmounted, watch } from 'vue'

import HousingForm from '@/Pages/Tenant/families/create/stepFour/HousingForm.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

const props = defineProps<{
    housing: FamilyEditHousingType
}>()

const createFamilyStore = useCreateFamilyStore()

const emit = defineEmits(['success'])

createFamilyStore.family.housing = props.housing

const form = useForm(
    'put',
    route('tenant.families.housing-update', props.housing.family_id),
    createFamilyStore.family.housing
)

const submit = () => {
    useForm(
        'put',
        route('tenant.families.housing-update', props.housing.family_id),
        createFamilyStore.family.housing
    ).submit({
        onSuccess() {
            emit('success')

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof FamilyUpdateHousingFormType)
            })
        }
    })
}

watch(
    () => createFamilyStore.family.housing,
    (value) => {
        form.setData({ ...value })
    },
    { deep: true }
)

onUnmounted(() => {
    createFamilyStore.$reset()
})
</script>

<template>
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('housing information') }}</h2>
        </div>

        <form @submit.prevent="submit">
            <div class="p-5">
                <housing-form :form="form"></housing-form>

                <base-button :disabled="form.processing" class="!mt-6 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
</template>
