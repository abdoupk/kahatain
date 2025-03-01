<script lang="ts" setup>
import type { CreateFamilyStepProps } from '@/types/types'

import { useCreateFamilyStore } from '@/stores/create-family'
import { ref } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import TheAddressField from '@/Components/Global/TheAddressField/TheAddressField.vue'
import TheBranchSelector from '@/Components/Global/TheBranchSelector.vue'
import TheZoneSelector from '@/Components/Global/TheZoneSelector.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<CreateFamilyStepProps>()

const createFamilyStore = useCreateFamilyStore()

const _residenceCertificateFile = ref(props.form?.residence_certificate_file)
</script>

<template>
    <div
        v-if="createFamilyStore.current_step === 1"
        class="mt-10 border-t border-slate-200/60 px-5 pt-10 dark:border-darkmode-400 sm:px-20"
    >
        <div class="mb-6 hidden text-lg font-bold lg:block">
            {{ $t('families.create_family.stepOne') }}
        </div>

        <div class="mt-5 grid grid-cols-12 gap-4 gap-y-5">
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="start_date">
                    {{ $t('validation.attributes.starting_sponsorship_date') }}
                </base-form-label>

                <base-v-calendar v-model:date="createFamilyStore.family.start_date"></base-v-calendar>

                <base-form-input-error :form field_name="start_date"></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="branch">
                    {{ $t('the_branch') }}
                </base-form-label>

                <div>
                    <the-branch-selector
                        id="branch"
                        v-model:branch="createFamilyStore.family.branch_id"
                        v-model:city-id="createFamilyStore.family.city_id"
                        @update:branch="form?.validate('branch_id')"
                    ></the-branch-selector>
                </div>

                <base-form-input-error :form field_name="branch_id"></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="zone">
                    {{ $t('validation.attributes.zone') }}
                </base-form-label>

                <div>
                    <the-zone-selector
                        id="zone"
                        v-model:zone="createFamilyStore.family.zone_id"
                        @update:zone="form?.validate('zone_id')"
                    ></the-zone-selector>
                </div>

                <base-form-input-error :form field_name="zone_id"></base-form-input-error>
            </div>

            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="address">
                    {{ $t('validation.attributes.address') }}
                </base-form-label>

                <the-address-field
                    v-model:address="createFamilyStore.family.address"
                    v-model:location="createFamilyStore.family.location"
                    :select_location_label="$t('hints.select_family_location')"
                    @update:address="form?.validate('address')"
                ></the-address-field>

                <base-form-input-error :form field_name="address"></base-form-input-error>
            </div>

            <!-- Begin: Upload files  -->
            <div class="col-span-12 mt-6">
                <h1 class="mb-6 text-lg rtl:!font-semibold">{{ $t('upload-files.files') }}</h1>

                <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-12 lg:col-span-6">
                        <base-form-label class="mb-2" for="birth_certificate_file">
                            {{ $t('upload-files.labels.residence_certificate') }}
                        </base-form-label>

                        <base-file-pond
                            id="birth_certificate_file"
                            :allow-multiple="false"
                            :files="_residenceCertificateFile"
                            :is-picture="false"
                            :labelIdle="$t('upload-files.labelIdle.residence_certificate')"
                            accepted-file-types="image/jpeg, image/png, application/pdf"
                            @update:files="createFamilyStore.family.residence_certificate_file = $event[0]"
                        ></base-file-pond>
                    </div>
                </div>
            </div>
            <!-- End: Upload Files   -->
            <slot></slot>
        </div>
    </div>
</template>
