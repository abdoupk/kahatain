<script lang="ts" setup>
import type { FamilyEditType, FamilyUpdateFormType } from '@/types/families'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAddressField from '@/Components/Global/TheAddressField/TheAddressField.vue'
import TheBranchSelector from '@/Components/Global/TheBranchSelector.vue'
import TheZoneSelector from '@/Components/Global/TheZoneSelector.vue'

import { formatDate, omit } from '@/utils/helper'

const props = defineProps<{ family: FamilyEditType }>()

const inputs = reactive<FamilyUpdateFormType>(
    omit(props.family, [
        'id',
        'family_sponsorships',
        'housing',
        'furnishings',
        'second_sponsor',
        'preview',
        'name',
        'spouse'
    ])
)

const form = useForm('put', route('tenant.families.infos-update', props.family.id), inputs)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof FamilyUpdateFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: Family Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ family.name }}</h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-sm font-semibold text-slate-400 dark:bg-darkmode-400"
            >
                {{ formatDate(family.start_date, 'long') }}
            </div>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-4 p-5">
                <!-- BEGIN: File Number -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="file_number">
                        {{ $t('validation.attributes.file_number') }}
                    </base-form-label>

                    <base-form-input
                        id="file_number"
                        v-model="form.file_number"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.file_number')
                            })
                        "
                        data-test="orphan_file_number"
                        type="text"
                        @change="form?.validate('file_number')"
                    ></base-form-input>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('file_number')"
                            class="mt-2 text-danger"
                            data-test="error_file_number_message"
                        >
                            {{ form.errors.file_number }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: File Number -->

                <!-- BEGIN: Branch -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="zone_id">
                        {{ $t('validation.attributes.zone_id') }}
                    </base-form-label>

                    <the-zone-selector
                        id="zone_id"
                        v-model:zone="form.zone_id"
                        @update:zone="form?.validate('zone_id')"
                    ></the-zone-selector>

                    <base-form-input-error>
                        <div v-if="form?.invalid('zone_id')" class="mt-2 text-danger" data-test="error_zone_id_message">
                            {{ form.errors.zone_id }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Branch -->

                <!-- BEGIN: Zone -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="branch_id">
                        {{ $t('validation.attributes.branch_id') }}
                    </base-form-label>

                    <the-branch-selector
                        id="branch_id"
                        v-model:branch="form.branch_id"
                        @update:branch="form?.validate('branch_id')"
                    ></the-branch-selector>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('branch_id')"
                            class="mt-2 text-danger"
                            data-test="error_branch_id_message"
                        >
                            {{ form.errors.branch_id }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Zone -->

                <!-- BEGIN: Address -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="address">
                        {{ $t('validation.attributes.address') }}
                    </base-form-label>
                    
                    <the-address-field
                        v-model:address="form.address"
                        v-model:location="form.location"
                        @input="form?.validate('address')"
                    ></the-address-field>

                    <base-form-input-error>
                        <div v-if="form?.invalid('address')" class="mt-2 text-danger" data-test="error_address_message">
                            {{ form.errors.address }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Address -->

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Family Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
