<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'
import type { CreateFamilyForm } from '@/types/types'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted, ref } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheSponsorTypeSelector from '@/Components/Global/TheSponsorTypeSelector.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    form?: Form<CreateFamilyForm>
}>()

const academicLevelsStore = useAcademicLevelsStore()

const createFamilyStore = useCreateFamilyStore()

const academicLevels = ref<AcademicLevelType[]>([])

const _diplomaFile = ref(props.form?.sponsor?.diploma_file)

const _birthCertificateFile = ref(props.form?.sponsor?.birth_certificate_file)

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForSponsors()
})

onMounted(() => {
    document.getElementById('first_name')?.focus()
})
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <!-- Begin: Photo-->

        <div class="col-span-12">
            <div class="me-2 ms-auto h-36 w-36">
                <base-file-pond
                    id="photo"
                    :allow-multiple="false"
                    :files="pic"
                    is-picture
                    :labelIdle="$t('upload-files.labelIdle.sponsor_photo')"
                    @update:files="photo = $event[0]"
                ></base-file-pond>
            </div>
        </div>
        <!-- End: Photo-->

        <!-- Begin: First Name -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="first_name">
                {{ $t('validation.attributes.first_name') }}
            </base-form-label>

            <base-form-input
                id="first_name"
                v-model="createFamilyStore.family.sponsor.first_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.first_name')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.first_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.first_name"> </base-form-input-error>
        </div>
        <!-- END: First Name -->

        <!-- Begin: Last Name -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="last_name">
                {{ $t('validation.attributes.last_name') }}
            </base-form-label>

            <base-form-input
                id="last_name"
                v-model="createFamilyStore.family.sponsor.last_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.last_name')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.last_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.last_name"> </base-form-input-error>
        </div>
        <!-- End: Last Name -->

        <!-- Begin: CCP -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="ccp">
                {{ $t('ccp') }}
            </base-form-label>

            <base-form-input
                id="ccp"
                v-model="createFamilyStore.family.sponsor.ccp"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('ccp')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.ccp'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.ccp"> </base-form-input-error>
        </div>
        <!-- End: CCP -->

        <!-- Begin: Branch -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="sponsor_type">
                {{ $t('filters.sponsor_type') }}
            </base-form-label>

            <div>
                <!-- @vue-ignore -->
                <the-sponsor-type-selector
                    v-model:type="createFamilyStore.family.sponsor.sponsor_type"
                    @update:type="form?.validate('sponsor.sponsor_type')"
                ></the-sponsor-type-selector>
            </div>

            <base-form-input-error :form field_name="sponsor.sponsor_type"> </base-form-input-error>
        </div>
        <!-- End: Branch -->

        <!-- Begin: Birth Date -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="sponsor.birth_date">
                {{ $t('validation.attributes.sponsor.birth_date') }}
            </base-form-label>

            <base-v-calendar v-model:date="createFamilyStore.family.sponsor.birth_date"></base-v-calendar>

            <base-form-input-error :form field_name="sponsor.birth_date"> </base-form-input-error>
        </div>
        <!-- End: Birth Date -->

        <!-- Begin: Phone Number -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="phone_number">
                {{ $t('validation.attributes.phone') }}
            </base-form-label>

            <base-form-input
                id="phone_number"
                v-model="createFamilyStore.family.sponsor.phone_number"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.phone')
                    })
                "
                maxlength="10"
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.phone_number'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.phone_number"> </base-form-input-error>
        </div>
        <!-- End: Phone Number -->

        <!-- Begin: Father Name -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="father_name">
                {{ $t('validation.attributes.sponsor.father_name') }}
            </base-form-label>

            <base-form-input
                id="father_name"
                v-model="createFamilyStore.family.sponsor.father_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.father_name')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.father_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.father_name"> </base-form-input-error>
        </div>
        <!-- End: Father Name -->

        <!-- Begin: Mother Name -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="mother_name">
                {{ $t('validation.attributes.sponsor.mother_name') }}
            </base-form-label>

            <base-form-input
                id="mother_name"
                v-model="createFamilyStore.family.sponsor.mother_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.mother_name')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.mother_name'
                    )
                "
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.mother_name"> </base-form-input-error>
        </div>
        <!-- End: Mother Name -->

        <!-- Begin: Birth Certificate Number -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="birth_certificate_number">
                {{ $t('validation.attributes.sponsor.birth_certificate_number') }}
            </base-form-label>

            <base-form-input
                id="birth_certificate_number"
                v-model="createFamilyStore.family.sponsor.birth_certificate_number"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.birth_certificate_number')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.birth_certificate_number'
                    )
                "
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.birth_certificate_number"> </base-form-input-error>
        </div>
        <!-- End: Birth Certificate Number -->

        <!-- Begin: Academic Level -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="academic_level">
                {{ $t('validation.attributes.sponsor.academic_level') }}
            </base-form-label>

            <div>
                <!-- @vue-ignore -->
                <the-academic-level-selector
                    id="academic_level"
                    v-model:academic-level="createFamilyStore.family.sponsor.academic_level_id"
                    :academicLevels
                    @update:academic-level="form?.validate(`sponsor.academic_level_id`)"
                ></the-academic-level-selector>
            </div>

            <base-form-input-error :form field_name="sponsor.academic_level_id"> </base-form-input-error>
        </div>
        <!-- End: Academic Level -->

        <!-- Begin: Function -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="function">
                {{ $t('validation.attributes.sponsor.function') }}
            </base-form-label>

            <base-form-input
                id="function"
                v-model="createFamilyStore.family.sponsor.function"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.function')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.function'
                    )
                "
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.function"> </base-form-input-error>
        </div>
        <!-- End: Function -->

        <!-- Begin: Health Status -->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="health_status">
                {{ $t('validation.attributes.sponsor.health_status') }}
            </base-form-label>

            <base-form-input
                id="health_status"
                v-model="createFamilyStore.family.sponsor.health_status"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.health_status')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.health_status'
                    )
                "
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.health_status"> </base-form-input-error>
        </div>
        <!-- End: Health Status -->

        <!-- Begin: Diploma -->
        <div class="col-span-7 sm:col-span-6">
            <base-form-label for="diploma">
                {{ $t('validation.attributes.sponsor.diploma') }}
            </base-form-label>

            <base-form-input
                id="diploma"
                v-model="createFamilyStore.family.sponsor.diploma"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.diploma')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        'sponsor.diploma'
                    )
                "
            ></base-form-input>

            <base-form-input-error :form field_name="sponsor.diploma"> </base-form-input-error>
        </div>
        <!-- End: Diploma -->

        <!--Begin: Unemployed-->
        <div class="col-span-5 mt-6 flex items-center sm:col-span-6">
            <base-form-switch class="text-lg">
                <base-form-switch-input
                    id="is_unemployed"
                    v-model="createFamilyStore.family.sponsor.is_unemployed"
                    type="checkbox"
                ></base-form-switch-input>

                <base-form-switch-label class="whitespace-nowrap" htmlFor="is_unemployed">
                    {{ $t('unemployed') }}
                </base-form-switch-label>
            </base-form-switch>
        </div>
        <!--END: Unemployed-->

        <!-- Begin: Upload files  -->
        <div class="col-span-12 mt-6">
            <h1 class="mb-6 text-lg rtl:!font-semibold">{{ $t('upload-files.files') }}</h1>

            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-12 lg:col-span-6">
                    <base-form-label class="mb-2" for="birth_certificate_file">
                        {{ $t('upload-files.labels.birth_certificate') }}
                    </base-form-label>

                    <base-file-pond
                        id="birth_certificate_file"
                        :allow-multiple="false"
                        :files="_birthCertificateFile"
                        :is-picture="false"
                        accepted-file-types="image/jpeg, image/png, application/pdf"
                        @update:files="createFamilyStore.family.sponsor.birth_certificate_file = $event[0]"
                    ></base-file-pond>
                </div>

                <div class="col-span-12 lg:col-span-6">
                    <base-form-label class="mb-2" for="diploma_file">
                        {{ $t('diploma') }}
                    </base-form-label>

                    <base-file-pond
                        id="diploma_file"
                        :allow-multiple="false"
                        :files="_diplomaFile"
                        :is-picture="false"
                        accepted-file-types="image/jpeg, image/png, application/pdf"
                        @update:files="createFamilyStore.family.sponsor.diploma_file = $event[0]"
                    ></base-file-pond>
                </div>
            </div>
        </div>
        <!-- End: Upload Files   -->

        <slot></slot>
    </div>
</template>
