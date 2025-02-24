<script lang="ts" setup>
import type { FamilySponsorshipType, FamilyUpdateSponsorShipsFormType } from '@/types/families'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import FamilySponsorShipForm from '@/Pages/Tenant/families/create/stepFiveOld/FamilySponsorShipForm.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { omit } from '@/utils/helper'

const props = defineProps<{ sponsorships: FamilySponsorshipType }>()

const inputs = reactive<FamilyUpdateSponsorShipsFormType>(omit(props.sponsorships, ['family_id', 'id']))

const form = useForm('put', route('tenant.families.sponsorships-update', props.sponsorships.family_id), inputs)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof FamilyUpdateSponsorShipsFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: Family SponsorShip -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('family_sponsorship') }}</h2>
        </div>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-4 p-5">
                <family-sponsor-ship-form
                    v-model:eid-al-adha="form.eid_al_adha"
                    v-model:housing-assistance="form.housing_assistance"
                    v-model:monthly-allowance="form.monthly_allowance"
                    v-model:ramadan-basket="form.ramadan_basket"
                    v-model:zakat="form.zakat"
                    :form="form"
                    class="col-span-12"
                ></family-sponsor-ship-form>

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Family SponsorShip -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
