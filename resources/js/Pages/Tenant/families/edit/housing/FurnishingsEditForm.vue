<script lang="ts" setup>
import type { FamilyUpdateFurnishingFormType, FurnishingType } from '@/types/families'

import { useCreateFamilyStore } from '@/stores/create-family'
import { useForm } from 'laravel-precognition-vue'
import { onUnmounted, watch } from 'vue'

import FurnishingForm from '@/Pages/Tenant/families/create/stepFour/FurnishingForm.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

const props = defineProps<{
    furnishings: FurnishingType
    familyId: string
}>()

const createFamilyStore = useCreateFamilyStore()

const form = useForm('put', route('tenant.families.furnishings-update', props.familyId), props.furnishings)

createFamilyStore.family.furnishings = props.furnishings

const emit = defineEmits(['success'])

const submit = () => {
    form.submit({
        onSuccess() {
            // UpdateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof FamilyUpdateFurnishingFormType)
            })

            emit('success')
        }
    })
}

watch(
    () => createFamilyStore.family.furnishings,
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
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">
                {{ $t('furnishings information') }}
            </h2>
        </div>

        <form @submit.prevent="submit">
            <div class="p-5">
                <furnishing-form></furnishing-form>

                <base-button :disabled="form.processing" class="!mt-6 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
</template>
