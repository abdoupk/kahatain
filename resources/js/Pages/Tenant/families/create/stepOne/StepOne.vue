<script lang="ts" setup>
import type { CreateFamilyStepProps } from '@/types/types'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import TheBranchSelector from '@/Components/Global/TheBranchSelector.vue'
import TheZoneSelector from '@/Components/Global/TheZoneSelector.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'

defineProps<CreateFamilyStepProps>()

const zone = defineModel('zone', { default: '' })

const branch = defineModel('branch', { default: '' })

const startDate = defineModel('startDate', { default: '' })

const address = defineModel('address')

const fileNumber = defineModel('fileNumber')
</script>

<template>
    <div
        v-if="currentStep === 1"
        class="mt-10 border-t border-slate-200/60 px-5 pt-10 dark:border-darkmode-400 sm:px-20"
    >
        <div class="mb-6 hidden text-lg font-medium lg:block">
            {{ $t('families.create_family.stepOne') }}
        </div>

        <div class="mt-5 grid grid-cols-12 gap-4 gap-y-5">
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="file_number">
                    {{ $t('validation.attributes.file_number') }}
                </base-form-label>

                <base-form-input
                    id="file_number"
                    v-model="fileNumber"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('file_number')
                        })
                    "
                    autofocus
                    type="text"
                    @input="form?.validate('file_number')"
                    @keydown="allowOnlyNumbersOnKeyDown"
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

            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="start_date">
                    {{ $t('validation.attributes.starting_sponsorship_date') }}
                </base-form-label>

                <base-v-calendar v-model:date="startDate"></base-v-calendar>

                <base-form-input-error>
                    <div
                        v-if="form?.invalid('start_date')"
                        class="mt-2 text-danger"
                        data-test="error_start_date_message"
                    >
                        {{ form.errors.start_date }}
                    </div>
                </base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="branch">
                    {{ $t('the_branch') }}
                </base-form-label>

                <div>
                    <the-branch-selector
                        id="branch"
                        v-model:branch="branch"
                        @update:branch="form?.validate('branch_id')"
                    ></the-branch-selector>
                </div>

                <base-form-input-error>
                    <div v-if="form?.invalid('branch_id')" class="mt-2 text-danger" data-test="error_branch_message">
                        {{ form.errors.branch_id }}
                    </div>
                </base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="zone">
                    {{ $t('validation.attributes.zone') }}
                </base-form-label>

                <div>
                    <the-zone-selector
                        id="zone"
                        v-model:zone="zone"
                        @update:zone="form?.validate('zone_id')"
                    ></the-zone-selector>
                </div>

                <base-form-input-error>
                    <div v-if="form?.invalid('zone_id')" class="mt-2 text-danger" data-test="error_zone_message">
                        {{ form.errors.zone_id }}
                    </div>
                </base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="address">
                    {{ $t('validation.attributes.address') }}
                </base-form-label>
                <base-form-input
                    id="address"
                    v-model="address"
                    placeholder="حي الحياة تجزئة ب رقم '89' البيض"
                    type="text"
                    @input="form?.validate('address')"
                ></base-form-input>
                <base-form-input-error>
                    <div v-if="form?.invalid('address')" class="mt-2 text-danger" data-test="error_address_message">
                        {{ form.errors.address }}
                    </div>
                </base-form-input-error>
            </div>

            <slot></slot>
        </div>
    </div>
</template>
