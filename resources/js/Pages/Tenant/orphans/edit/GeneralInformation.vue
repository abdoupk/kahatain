<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'
import type { OrphanUpdateFormType } from '@/types/orphans'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, onMounted, reactive, ref } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAcademicInfos from '@/Components/Global/TheAcademicInfos.vue'
import TheBabyMilkSelector from '@/Components/Global/TheBabyMilkSelector.vue'
import TheClothesSizeSelector from '@/Components/Global/TheClothesSizeSelector.vue'
import TheDiapersSelector from '@/Components/Global/TheDiapersSelector.vue'
import TheFamilyStatusSelector from '@/Components/Global/TheFamilyStatusSelector.vue'
import TheShoesSizeSelector from '@/Components/Global/TheShoesSizeSelector.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { hasPermission, isOlderThan, omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const emit = defineEmits(['orphan-updated'])

const inputs = reactive<OrphanUpdateFormType>(omit(props.orphan, ['id', 'creator']))

const form = useForm('put', route('tenant.orphans.infos-update', props.orphan.id), inputs)

const pic = ref(props.orphan.photo)

const updateSuccess = ref(false)

const isOlderThan18 = computed(() => isOlderThan(form.birth_date, 18))

const isShouldHasIncome = computed(() => {
    if (!isOlderThan18.value) return false

    const phase = useAcademicLevelsStore().getPhaseFromId(form.academic_level_id)

    if (
        // eslint-disable-next-line array-element-newline
        [
            'secondary_education',
            'middle_education',
            'primary_education',
            'license',
            'master',
            'doctorate',
            'university'
        ].includes(phase)
    )
        return false

    return !form.is_handicapped && !form.is_unemployed
})

const isShouldHasUnemploymentBenefit = computed(() => {
    const phase = useAcademicLevelsStore().getPhaseFromId(form.academic_level_id)

    if (['paramedical', 'vocational_training'].includes(phase)) return false

    return isShouldHasIncome.value
})

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof OrphanUpdateFormType)
            })

            emit('orphan-updated', { ...props.orphan, ...form.data() })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}

const academicLevels = ref<AcademicLevelType[]>([])

const academicLevelsStore = useAcademicLevelsStore()

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForOrphans()
})
</script>

<template>
    <!-- BEGIN: Orphan Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">
                {{ $t('display information') }}
            </h2>

            <Link v-if="hasPermission('show_orphans')" :href="route('tenant.orphans.show', orphan.id)">
                <svg-loader class="inline h-4 w-4" name="icon-eye"></svg-loader>

                {{ $t('show') }}
            </Link>
        </div>

        <form @submit.prevent="submit">
            <!-- Begin: Photo -->
            <div class="me-2 ms-auto mt-2 h-36 w-36">
                <base-file-pond
                    id="photo"
                    :allow-multiple="false"
                    :files="pic"
                    :labelIdle="$t('upload-files.labelIdle.orphan_photo')"
                    is-picture
                    @update:files="form.photo = $event[0]"
                ></base-file-pond>
            </div>
            <!-- End: Photo -->

            <div class="grid grid-cols-12 gap-4 p-5">
                <!-- BEGIN: First Name -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="first_name">
                        {{ $t('validation.attributes.first_name') }}
                    </base-form-label>

                    <base-form-input
                        id="first_name"
                        v-model="form.first_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.first_name')
                            })
                        "
                        data-test="orphan_first_name"
                        type="text"
                        @change="form?.validate('first_name')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="first_name"></base-form-input-error>
                </div>
                <!-- END: First Name -->

                <!-- BEGIN: Last Name -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="last_name">
                        {{ $t('validation.attributes.last_name') }}
                    </base-form-label>

                    <base-form-input
                        id="last_name"
                        v-model="form.last_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.last_name')
                            })
                        "
                        data-test="orphan_last_name"
                        type="text"
                        @change="form?.validate('last_name')"
                    ></base-form-input>

                    <base-form-input-error :form field_name="last_name"></base-form-input-error>
                </div>
                <!-- END: Last Name -->

                <!-- BEGIN: BirthDate -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="birth_date">
                        {{ $t('validation.attributes.spouse.birth_date') }}
                    </base-form-label>

                    <base-v-calendar v-model:date="form.birth_date"></base-v-calendar>

                    <base-form-input-error :form field_name="birth_date"></base-form-input-error>
                </div>
                <!-- END: BirthDate -->

                <!-- BEGIN: Family Status -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="family_status">
                        {{ $t('family_status') }}
                    </base-form-label>

                    <the-family-status-selector
                        id="family_status"
                        v-model:family-status="form.family_status"
                        v-model:gender="form.gender"
                        @update:family-status="form?.validate(`family_status`)"
                        :allow-empty="true"
                    >
                    </the-family-status-selector>

                    <base-form-input-error :form field_name="family_status"></base-form-input-error>
                </div>
                <!-- END: Family Status -->

                <!-- BEGIN: Academic Level -->
                <the-academic-infos
                    v-model:academic-level="form.academic_level_id"
                    v-model:ccp="form.ccp"
                    v-model:institution="form.institution"
                    v-model:institution-type="form.institution_type"
                    v-model:phone-number="form.phone_number"
                    v-model:speciality-id="form.speciality_id"
                    v-model:speciality-type="form.speciality_type"
                    :birth-date="form.birth_date"
                    :form
                    academic_level_id_field_name="academic_level_id"
                    birth_date_field_name="birth_date"
                    ccp_field_name="ccp"
                    institution_field_name="institution_id"
                    phone_number_field_name="phone_number"
                    vocational_training_id_field_name="vocational_training_id"
                    @update:institution="form.institution_id = $event.id"
                ></the-academic-infos>
                <!-- END: Academic Level -->

                <!-- BEGIN: Gender -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="gender">
                        {{ $t('validation.attributes.gender') }}
                    </base-form-label>

                    <base-form-select
                        id="gender"
                        v-model="form.gender"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.gender')
                            })
                        "
                        data-test="orphan_gender"
                        @change="form?.validate('gender')"
                    >
                        <option value="male">{{ $t('male') }}</option>
                        <option value="female">{{ $t('female') }}</option>
                    </base-form-select>

                    <base-form-input-error :form field_name="gender"></base-form-input-error>
                </div>
                <!-- END: Gender -->

                <template v-if="isOlderThan(form.birth_date, 2)">
                    <!-- BEGIN: Pants Size -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="pants_size">
                            {{ $t('pants_size') }}
                        </base-form-label>

                        <div>
                            <the-clothes-size-selector
                                id="pants_size"
                                v-model:size="form.pants_size"
                                :placeholder="$t('auth.placeholders.fill', { attribute: $t('pants_size') })"
                                @update:size="form?.validate('pants_size')"
                            ></the-clothes-size-selector>
                        </div>

                        <base-form-input-error :form field_name="pants_size"></base-form-input-error>
                    </div>
                    <!-- END: Pants Size -->

                    <!-- BEGIN: Shirt Size -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="shirt_size">
                            {{ $t('shirt_size') }}
                        </base-form-label>

                        <div>
                            <the-clothes-size-selector
                                id="shirt_size"
                                v-model:size="form.shirt_size"
                                :placeholder="$t('auth.placeholders.fill', { attribute: $t('shirt_size') })"
                                @update:size="form?.validate('shirt_size')"
                            ></the-clothes-size-selector>
                        </div>

                        <base-form-input-error :form field_name="shirt_size"></base-form-input-error>
                    </div>
                    <!-- END: Shirt Size -->

                    <!-- BEGIN: Shoes Size -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="shoes_size">
                            {{ $t('shoes_size') }}
                        </base-form-label>

                        <div>
                            <the-shoes-size-selector
                                id="shoes_size"
                                v-model:size="form.shoes_size"
                                @update:size="form?.validate('shoes_size')"
                            ></the-shoes-size-selector>
                        </div>

                        <base-form-input-error :form field_name="shoes_size"></base-form-input-error>
                    </div>
                    <!-- END: Shoes Size -->
                </template>

                <template v-else>
                    <!-- BEGIN: Diapers Type -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="diapers_type">
                            {{ $t('diapers_type') }}
                        </base-form-label>

                        <the-diapers-selector
                            id="diapers_type"
                            v-model:diaper="form.diapers_type"
                            @update:diaper="form?.validate('diapers_type')"
                        ></the-diapers-selector>

                        <base-form-input-error :form field_name="diapers_type"></base-form-input-error>
                    </div>
                    <!-- END: Diapers Type -->

                    <!-- BEGIN: Diapers Quantity -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="diapers_quantity">
                            {{ $t('diapers_quantity_label') }}
                        </base-form-label>

                        <base-form-input
                            id="diapers_quantity"
                            v-model="form.diapers_quantity"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('diapers_quantity')
                                })
                            "
                            data-test="orphan_diapers_quantity"
                            type="text"
                            @change="form?.validate('diapers_quantity')"
                        ></base-form-input>

                        <base-form-input-error :form field_name="diapers_quantity"></base-form-input-error>
                    </div>
                    <!-- END: Diapers Quantity -->

                    <!-- BEGIN: Baby Milk Type -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="baby_milk_type">
                            {{ $t('baby_milk_type') }}
                        </base-form-label>

                        <the-baby-milk-selector
                            id="baby_milk_type"
                            v-model:baby-milk="form.baby_milk_type"
                            @update:baby-milk="form?.validate('baby_milk_type')"
                        ></the-baby-milk-selector>

                        <base-form-input-error :form field_name="baby_milk_type"></base-form-input-error>
                    </div>
                    <!-- END: Baby Milk Type -->

                    <!-- BEGIN: Baby Milk Quantity -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="baby_milk_quantity">
                            {{ $t('baby_milk_quantity_label') }}
                        </base-form-label>

                        <base-form-input
                            id="baby_milk_quantity"
                            v-model="form.baby_milk_quantity"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('baby_milk_quantity')
                                })
                            "
                            data-test="orphan_baby_milk_quantity"
                            type="text"
                            @change="form?.validate('baby_milk_quantity')"
                        ></base-form-input>

                        <base-form-input-error :form field_name="baby_milk_quantity"></base-form-input-error>
                    </div>
                    <!-- END: Baby Milk Quantity -->
                </template>

                <div class="col-span-12 grid grid-cols-12 gap-4 sm:col-span-6 sm:mt-8">
                    <!--Begin: Handicapped-->
                    <div class="col-span-6 sm:col-span-3">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                :id="`is_handicapped`"
                                v-model="form.is_handicapped"
                                type="checkbox"
                            ></base-form-switch-input>

                            <base-form-switch-label :htmlFor="`is_handicapped`" class="whitespace-nowrap text-nowrap">
                                {{ $t('handicapped') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>
                    <!--END: Handicapped-->

                    <!--Begin: Unemployed-->
                    <div v-if="isShouldHasUnemploymentBenefit" class="col-span-6 ms-0 sm:col-span-3 sm:ms-12">
                        <base-form-switch class="text-lg">
                            <base-form-switch-input
                                :id="`is_unemployed`"
                                v-model="form.is_unemployed"
                                type="checkbox"
                            ></base-form-switch-input>

                            <base-form-switch-label :htmlFor="`is_unemployed`" class="whitespace-nowrap text-nowrap">
                                {{ $t('unemployed') }}
                            </base-form-switch-label>
                        </base-form-switch>
                    </div>
                    <!--END: Unemployed-->
                </div>

                <!-- Begin: Income-->
                <div v-if="isShouldHasIncome" class="col-span-12 sm:col-span-6">
                    <base-form-label for="income">
                        {{ $t('validation.attributes.income') }}
                    </base-form-label>

                    <base-input-group>
                        <base-form-input
                            v-model="form.income"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('validation.attributes.income')
                                })
                            "
                            data-test="orphan_income"
                            maxlength="12"
                            type="text"
                            @change="form?.validate('income')"
                        ></base-form-input>

                        <base-input-group-text>
                            {{ $t('DA') }}
                        </base-input-group-text>
                    </base-input-group>

                    <base-form-input-error :form field_name="income"></base-form-input-error>
                </div>
                <!-- End: Income-->

                <!-- BEGIN: Notes -->
                <div class="col-span-12">
                    <base-form-label for="note">
                        {{ $t('validation.attributes.note') }}
                    </base-form-label>

                    <base-form-text-area
                        id="note"
                        v-model="form.note"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.note')
                            })
                        "
                        data-test="orphan_note"
                        rows="8"
                        @change="form?.validate('note')"
                    ></base-form-text-area>

                    <base-form-input-error :form="form" field_name="note"></base-form-input-error>
                </div>
                <!-- END: Notes -->

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
    </div>
    <!-- END: Orphan Information -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
