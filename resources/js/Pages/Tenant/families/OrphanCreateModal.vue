<script lang="ts" setup>
import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAcademicInfos from '@/Components/Global/TheAcademicInfos.vue'
import TheBabyMilkSelector from '@/Components/Global/TheBabyMilkSelector.vue'
import TheClothesSizeSelector from '@/Components/Global/TheClothesSizeSelector.vue'
import TheDiapersSelector from '@/Components/Global/TheDiapersSelector.vue'
import TheFamilyStatusSelector from '@/Components/Global/TheFamilyStatusSelector.vue'
import TheShoesSizeSelector from '@/Components/Global/TheShoesSizeSelector.vue'

import { isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const firstInputRef = ref<HTMLElement>()

const props = defineProps<{
    familyId: string
    open: boolean
}>()

const form = useForm('post', route('tenant.orphans.store'), {
    first_name: '',
    last_name: '',
    birth_date: '',
    gender: 'male',
    family_id: props.familyId,
    academic_level_id: '',
    vocational_training_id: '',
    note: '',
    health_status: '',
    family_status: '',
    is_unemployed: false,
    is_handicapped: false,
    institution_id: '',
    ccp: '',
    phone_number: '',
    shoes_size: '',
    pants_size: '',
    shirt_size: '',
    baby_milk_quantity: '',
    baby_milk_type: '',
    diapers_quantity: '',
    diapers_type: ''
})

const showSuccessNotification = ref(true)

const submit = () => {
    loading.value = true

    form.submit({
        onSuccess() {
            emit('close')

            loading.value = false

            // Form.reset()
        },
        onFinish() {
            loading.value = false
        }
    })
}

const emit = defineEmits(['close'])

const loading = ref(false)

const isStillBaby = computed(() => {
    return form.birth_date && !isOlderThan(form.birth_date, 2)
})

const isOlderThan18 = computed(() => {
    return form.birth_date && isOlderThan(form.birth_date, 18)
})

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

    return !form.is_handicapped
})

const isShouldHasUnemploymentBenefit = computed(() => {
    const phase = useAcademicLevelsStore().getPhaseFromId(form.academic_level_id)

    if (['paramedical', 'vocational_training'].includes(phase)) return false

    return isShouldHasIncome.value
})
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :open
        :title="$t('new orphan')"
        modal-type="create"
        size="xl"
        @close="emit('close')"
        @handle-submit="submit"
    >
        <template #body>
            <div class="grid grid-cols-12 gap-4 gap-y-5">
                <!-- Begin: Last Name-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label :for="`last_name`">
                        {{ $t('validation.attributes.last_name') }}
                    </base-form-label>

                    <base-form-input
                        :id="`last_name`"
                        v-model="form.last_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.last_name')
                            })
                        "
                        data-test="orphan_last_name"
                        type="text"
                        @change="form?.validate(`last_name`)"
                    ></base-form-input>

                    <base-form-input-error :field_name="`last_name`" :form></base-form-input-error>
                </div>
                <!-- End: Last Name-->

                <!-- Begin: First Name-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label :for="`first_name`">
                        {{ $t('validation.attributes.first_name') }}
                    </base-form-label>

                    <base-form-input
                        :id="`first_name`"
                        v-model="form.first_name"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.first_name')
                            })
                        "
                        data-test="orphan_first_name"
                        type="text"
                        @change="form?.validate(`first_name`)"
                    ></base-form-input>

                    <base-form-input-error :field_name="`first_name`" :form></base-form-input-error>
                </div>
                <!-- End: First Name-->

                <!-- Begin: Birth Date-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label :for="`birth_date`">
                        {{ $t('validation.attributes.date_of_birth') }}
                    </base-form-label>

                    <base-v-calendar v-model:date="form.birth_date"></base-v-calendar>

                    <base-form-input-error :field_name="`birth_date`" :form></base-form-input-error>
                </div>
                <!-- End: Birth Date-->

                <!-- Begin: Gender-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label :for="`gender`">
                        {{ $t('validation.attributes.gender') }}
                    </base-form-label>

                    <base-form-select
                        :id="`gender`"
                        v-model="form.gender"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.gender')
                            })
                        "
                        data-test="orphan_gender"
                        @change="form?.validate(`gender`)"
                    >
                        <option value="male">{{ $t('male') }}</option>

                        <option value="female">{{ $t('female') }}</option>
                    </base-form-select>

                    <base-form-input-error :field_name="`gender`" :form></base-form-input-error>
                </div>
                <!-- End: Gender-->

                <!-- Begin: Health Status-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label :for="`health_status`">
                        {{ $t('validation.attributes.sponsor.health_status') }}
                    </base-form-label>

                    <base-form-input
                        :id="`health_status`"
                        v-model="form.health_status"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.sponsor.health_status')
                            })
                        "
                        type="text"
                        @change="form?.validate(`health_status`)"
                    ></base-form-input>

                    <base-form-input-error :field_name="`health_status`" :form></base-form-input-error>
                </div>
                <!-- End: Health Status-->

                <!-- Begin: Family Status-->
                <div v-if="isOlderThan18" class="col-span-12 sm:col-span-6">
                    <base-form-label :for="`family_status`">
                        {{ $t('family_status') }}
                    </base-form-label>

                    <div>
                        <the-family-status-selector
                            :id="`family_status`"
                            v-model:birth-date="form.birth_date"
                            v-model:family-status="form.family_status"
                            v-model:gender="form.gender"
                            @update:family-status="form?.validate(`family_status`)"
                        ></the-family-status-selector>
                    </div>

                    <base-form-input-error :field_name="`family_status`" :form></base-form-input-error>
                </div>
                <!-- End: Family Status-->

                <the-academic-infos
                    v-model:academic-level="form.academic_level_id"
                    v-model:birth-date="form.birth_date"
                    v-model:ccp="form.ccp"
                    v-model:institution="form.institution_id"
                    v-model:institution-type="form.institution_type"
                    v-model:phone-number="form.phone_number"
                    v-model:speciality-id="form.speciality_id"
                    v-model:speciality-type="form.speciality_type"
                    :academic_level_id_field_name="`academic_level_id`"
                    :birth_date_field_name="`birth_date`"
                    :ccp_field_name="`ccp`"
                    :form
                    :institution_field_name="`institution_id`"
                    :phone_number_field_name="`phone_number`"
                    :vocational_training_id_field_name="`vocational_training_id`"
                ></the-academic-infos>

                <!-- Begin: if orphan is still baby-->
                <div v-if="isStillBaby" class="col-span-12 grid grid-cols-12 gap-4 gap-y-5">
                    <!-- Begin: Baby Milk Type-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label :for="`baby_milk_type`">
                            {{ $t('baby_milk_type') }}
                        </base-form-label>

                        <the-baby-milk-selector
                            :id="`baby_milk_type`"
                            v-model:baby-milk="form.baby_milk_type"
                            @update:baby-milk="form?.validate(`baby_milk_type`)"
                        ></the-baby-milk-selector>

                        <base-form-input-error :field_name="`baby_milk_type`" :form></base-form-input-error>
                    </div>
                    <!-- End: Baby Milk Type-->

                    <!-- Begin: Baby Milk Quantity-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label :for="`baby_milk_quantity`">
                            {{ $t('baby_milk_quantity_label') }}
                        </base-form-label>

                        <base-form-input
                            :id="`baby_milk_quantity`"
                            v-model="form.baby_milk_quantity"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('baby_milk_quantity')
                                })
                            "
                            type="number"
                            @change="form?.validate(`baby_milk_quantity`)"
                        ></base-form-input>

                        <base-form-input-error :field_name="`baby_milk_quantity`" :form> </base-form-input-error>
                    </div>
                    <!-- End: Baby Milk Quantity-->

                    <!-- Begin: Diapers Type-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label :for="`diapers_type`">
                            {{ $t('diapers_type') }}
                        </base-form-label>

                        <the-diapers-selector
                            :id="`diapers_type`"
                            v-model:diaper="form.diapers_type"
                            @update:diaper="form?.validate(`diapers_type`)"
                        ></the-diapers-selector>

                        <base-form-input-error :field_name="`diapers_type`" :form></base-form-input-error>
                    </div>
                    <!-- End: Diapers Type-->

                    <!-- Begin: Diapers Quantity-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label :for="`diapers_quantity`">
                            {{ $t('diapers_quantity_label') }}
                        </base-form-label>

                        <base-form-input
                            :id="`diapers_quantity`"
                            v-model="form.diapers_quantity"
                            :placeholder="
                                $t('auth.placeholders.fill', {
                                    attribute: $t('diapers_quantity')
                                })
                            "
                            type="number"
                            @change="form?.validate(`diapers_quantity`)"
                        ></base-form-input>

                        <base-form-input-error :field_name="`diapers_quantity`" :form></base-form-input-error>
                    </div>
                    <!-- End: Diapers Quantity-->
                </div>
                <!-- End: if orphan is still baby-->

                <!-- Begin: if orphan is adult-->
                <template v-else>
                    <!-- Begin: Shoes Size-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label :for="`shoes_size`">
                            {{ $t('shoes_size') }}
                        </base-form-label>

                        <div>
                            <!-- @vue-ignore -->
                            <the-shoes-size-selector
                                :id="`shoes_size`"
                                v-model:size="form.shoes_size"
                                @update:size="
                                    form?.validate(
                                        //@ts-ignore
                                        `shoes_size`
                                    )
                                "
                            ></the-shoes-size-selector>
                        </div>

                        <base-form-input-error :field_name="`shoes_size`" :form></base-form-input-error>
                    </div>
                    <!-- End: Shoes Size-->

                    <!-- Begin: Shirt Size-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label :for="`shirt_size`">
                            {{ $t('shirt_size') }}
                        </base-form-label>

                        <div>
                            <!-- @vue-ignore -->
                            <the-clothes-size-selector
                                :id="`shirt_size`"
                                v-model:size="form.shirt_size"
                                :placeholder="$t('auth.placeholders.fill', { attribute: $t('shirt_size') })"
                                @update:size="
                                    form?.validate(
                                        //@ts-ignore
                                        `shirt_size`
                                    )
                                "
                            ></the-clothes-size-selector>
                        </div>

                        <base-form-input-error :field_name="`shirt_size`" :form></base-form-input-error>
                    </div>
                    <!-- End: Shirt Size-->

                    <!-- Begin: Pants Size-->
                    <div class="col-span-12 sm:col-span-6">
                        <base-form-label :for="`pants_size`">
                            {{ $t('pants_size') }}
                        </base-form-label>
                        <div>
                            <!-- @vue-ignore -->
                            <the-clothes-size-selector
                                :id="`pants_size`"
                                v-model:size="form.pants_size"
                                @update:size="
                                    form?.validate(
                                        //@ts-ignore
                                        `pants_size`
                                    )
                                "
                            ></the-clothes-size-selector>
                        </div>

                        <base-form-input-error :field_name="`pants_size`" :form></base-form-input-error>
                    </div>
                    <!-- End: Pants Size-->
                </template>
                <!-- End: if orphan is adult-->

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
                    <div v-if="isShouldHasUnemploymentBenefit" class="col-span-6 sm:col-span-3">
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
                    <base-form-label :for="`income`">
                        {{ $t('validation.attributes.income') }}
                    </base-form-label>

                    <base-form-input
                        :id="`income`"
                        v-model="form.income"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.income')
                            })
                        "
                        data-test="orphan_income"
                        type="text"
                        @change="form?.validate(`income`)"
                    ></base-form-input>

                    <base-form-input-error :field_name="`income`" :form></base-form-input-error>
                </div>
                <!-- End: Income-->

                <!-- Begin: Note -->
                <div class="col-span-8">
                    <base-form-label :for="`note`">
                        {{ $t('notes') }}
                    </base-form-label>

                    <base-form-text-area
                        :id="`note`"
                        v-model="form.note"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('notes')
                            })
                        "
                        type="text"
                        @change="form?.validate(`note`)"
                    ></base-form-text-area>

                    <base-form-input-error :field_name="`note`" :form></base-form-input-error>
                </div>
                <!-- End: Note -->

                <slot></slot>
            </div>
        </template>
    </create-edit-modal>

    <success-notification
        :open="showSuccessNotification"
        :title="$t('successfully_created', { attribute: $t('the_orphan') })"
    ></success-notification>
</template>
