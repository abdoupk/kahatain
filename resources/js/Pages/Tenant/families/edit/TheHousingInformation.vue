<script lang="ts" setup>
import type {
    FamilyEditHousingType,
    FamilyUpdateFurnishingFormType,
    FamilyUpdateHousingFormType,
    FurnishingType
} from '@/types/families'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import FurnishingForm from '@/Pages/Tenant/families/create/stepFour/FurnishingForm.vue'
import HousingForm from '@/Pages/Tenant/families/create/stepFour/HousingForm.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { omit } from '@/utils/helper'

const props = defineProps<{
    housing: FamilyEditHousingType
    furnishings: FurnishingType
}>()

const housingInputs = reactive<FamilyUpdateHousingFormType>(omit(props.housing, ['family_id', 'id']))

const furnishingsInputs = reactive<FamilyUpdateFurnishingFormType>(omit(props.furnishings, ['family_id', 'id']))

const housing_form = useForm('put', route('tenant.families.housing-update', props.housing.family_id), housingInputs)

const furnishings_form = useForm(
    'put',
    route('tenant.families.furnishings-update', props.housing.family_id),
    furnishingsInputs
)

const updateSuccess = ref(false)

const HousingSubmit = () => {
    housing_form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(housing_form.errors).forEach((error) => {
                housing_form.forgetError(error as keyof FamilyUpdateHousingFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}

const FurnishingsSubmit = () => {
    furnishings_form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(furnishings_form.errors).forEach((error) => {
                furnishings_form.forgetError(error as keyof FamilyUpdateFurnishingFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: Housing Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('housing information') }}</h2>
        </div>

        <form @submit.prevent="HousingSubmit">
            <div class="p-5">
                <housing-form
                    v-model:housing-receipt-number="housing_form.housing_receipt_number"
                    v-model:housing-type="housing_form.housing_type"
                    v-model:number-of-rooms="housing_form.number_of_rooms"
                    :form="housing_form"
                ></housing-form>

                <base-button :disabled="housing_form.processing" class="!mt-6 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="housing_form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Housing Information -->

    <!-- BEGIN: Furnishings Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">
                {{ $t('furnishings information') }}
            </h2>
        </div>

        <form @submit.prevent="FurnishingsSubmit">
            <div class="p-5">
                <furnishing-form
                    v-model:covers="furnishings_form.covers"
                    v-model:cupboard="furnishings_form.cupboard"
                    v-model:fireplace="furnishings_form.fireplace"
                    v-model:mattresses="furnishings_form.mattresses"
                    v-model:oven="furnishings_form.oven"
                    v-model:refrigerator="furnishings_form.refrigerator"
                    v-model:television="furnishings_form.television"
                    v-model:wardrobe="furnishings_form.wardrobe"
                    v-model:washing-machine="furnishings_form.washing_machine"
                    v-model:water-heater="furnishings_form.water_heater"
                    :form="furnishings_form"
                ></furnishing-form>

                <base-button :disabled="furnishings_form.processing" class="!mt-6 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="furnishings_form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Furnishings Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
