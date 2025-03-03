<script lang="ts" setup>
import type { CreateFamilyForm } from '@/types/types'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { computed, onMounted } from 'vue'

import BaseFilePond from '@/Components/Base/FilePond/BaseFilePond.vue'
import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import TheAcademicInfos from '@/Components/Global/TheAcademicInfos.vue'
import TheBabyMilkSelector from '@/Components/Global/TheBabyMilkSelector.vue'
import TheClothesSizeSelector from '@/Components/Global/TheClothesSizeSelector.vue'
import TheDiapersSelector from '@/Components/Global/TheDiapersSelector.vue'
import TheFamilyStatusSelector from '@/Components/Global/TheFamilyStatusSelector.vue'
import TheShoesSizeSelector from '@/Components/Global/TheShoesSizeSelector.vue'

import { isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    form: Form<CreateFamilyForm>
    index: number
}>()

const createFamilyStore = useCreateFamilyStore()

const isStillBaby = computed(() => {
    return (
        createFamilyStore.family.orphans[props.index].birth_date &&
        !isOlderThan(createFamilyStore.family.orphans[props.index].birth_date, 2)
    )
})

const isOlderThan18 = computed(() => {
    return (
        createFamilyStore.family.orphans[props.index].birth_date &&
        isOlderThan(createFamilyStore.family.orphans[props.index].birth_date, 18)
    )
})

const isShouldHasIncome = computed(() => {
    if (!isOlderThan18.value) return false

    const phase = useAcademicLevelsStore().getPhaseFromId(
        createFamilyStore.family.orphans[props.index].academic_level_id
    )

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

    return !createFamilyStore.family.orphans[props.index].is_handicapped
})

const isShouldHasUnemploymentBenefit = computed(() => {
    const phase = useAcademicLevelsStore().getPhaseFromId(
        createFamilyStore.family.orphans[props.index].academic_level_id
    )

    if (['paramedical', 'vocational_training'].includes(phase)) return false

    return isShouldHasIncome.value
})

const pic = props.form?.orphans[props.index]?.photo

onMounted(async () => {
    document.getElementById(`last_name_${props.index}`)?.focus()
})
</script>

<template>
    <div class="grid grid-cols-12 gap-4 gap-y-5 border-2 border-dashed px-2 pb-2.5 pt-2">
        <!-- Begin: Photo-->
        <div class="col-span-12">
            <div class="me-2 ms-auto mt-2 h-36 w-36">
                <base-file-pond
                    :id="`photo_${index}`"
                    :key="`photo_${index}`"
                    :allow-multiple="false"
                    :files="pic"
                    :labelIdle="$t('upload-files.labelIdle.orphan_photo')"
                    is-picture
                    @update:files="createFamilyStore.family.orphans[index].photo = $event[0]"
                ></base-file-pond>
            </div>
        </div>
        <!-- End: Photo-->

        <!-- Begin: Last Name-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="`last_name_${index}`">
                {{ $t('validation.attributes.last_name') }}
            </base-form-label>

            <base-form-input
                :id="`last_name_${index}`"
                v-model="createFamilyStore.family.orphans[index].last_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.last_name')
                    })
                "
                data-test="orphan_last_name"
                type="text"
                @change="form?.validate(`orphans.${index}.last_name`)"
            ></base-form-input>

            <base-form-input-error :field_name="`orphans.${index}.last_name`" :form></base-form-input-error>
        </div>
        <!-- End: Last Name-->

        <!-- Begin: First Name-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="`first_name_${index}`">
                {{ $t('validation.attributes.first_name') }}
            </base-form-label>

            <base-form-input
                :id="`first_name_${index}`"
                v-model="createFamilyStore.family.orphans[index].first_name"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.first_name')
                    })
                "
                data-test="orphan_first_name"
                type="text"
                @change="form?.validate(`orphans.${index}.first_name`)"
            ></base-form-input>

            <base-form-input-error :field_name="`orphans.${index}.first_name`" :form></base-form-input-error>
        </div>
        <!-- End: First Name-->

        <!-- Begin: Birth Date-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="`birth_date_${index}`">
                {{ $t('validation.attributes.date_of_birth') }}
            </base-form-label>

            <base-v-calendar v-model:date="createFamilyStore.family.orphans[index].birth_date"></base-v-calendar>

            <base-form-input-error :field_name="`orphans.${index}.birth_date`" :form></base-form-input-error>
        </div>
        <!-- End: Birth Date-->

        <!-- Begin: Gender-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="`gender_${index}`">
                {{ $t('validation.attributes.gender') }}
            </base-form-label>

            <base-form-select
                :id="`gender_${index}`"
                v-model="createFamilyStore.family.orphans[index].gender"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.gender')
                    })
                "
                data-test="orphan_gender"
                @change="form?.validate(`orphans.${index}.gender`)"
            >
                <option value="male">{{ $t('male') }}</option>

                <option value="female">{{ $t('female') }}</option>
            </base-form-select>

            <base-form-input-error :field_name="`orphans.${index}.gender`" :form></base-form-input-error>
        </div>
        <!-- End: Gender-->

        <!-- Begin: Health Status-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="`health_status_${index}`">
                {{ $t('validation.attributes.sponsor.health_status') }}
            </base-form-label>

            <base-form-input
                :id="`health_status_${index}`"
                v-model="createFamilyStore.family.orphans[index].health_status"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.health_status')
                    })
                "
                type="text"
                @change="form?.validate(`orphans.${index}.health_status`)"
            ></base-form-input>

            <base-form-input-error :field_name="`orphans.${index}.health_status`" :form></base-form-input-error>
        </div>
        <!-- End: Health Status-->

        <!-- Begin: Family Status-->
        <div v-if="isOlderThan18" class="col-span-12 sm:col-span-6">
            <base-form-label :for="`family_status_${index}`">
                {{ $t('family_status') }}
            </base-form-label>

            <div>
                <the-family-status-selector
                    :id="`family_status_${index}`"
                    v-model:family-status="createFamilyStore.family.orphans[index].family_status"
                    v-model:gender="createFamilyStore.family.orphans[index].gender"
                    @update:family-status="form?.validate(`orphans.${index}.family_status`)"
                    v-model:birth-date="createFamilyStore.family.orphans[index].birth_date"
                ></the-family-status-selector>
            </div>

            <base-form-input-error :field_name="`orphans.${index}.family_status`" :form></base-form-input-error>
        </div>
        <!-- End: Family Status-->

        <the-academic-infos
            v-model:academic-level="createFamilyStore.family.orphans[index].academic_level_id"
            v-model:birth-date="createFamilyStore.family.orphans[index].birth_date"
            v-model:ccp="createFamilyStore.family.orphans[index].ccp"
            v-model:institution="createFamilyStore.family.orphans[index].institution_id"
            v-model:institution-type="createFamilyStore.family.orphans[index].institution_type"
            v-model:phone-number="createFamilyStore.family.orphans[index].phone_number"
            v-model:speciality-id="createFamilyStore.family.orphans[index].speciality_id"
            v-model:speciality-type="createFamilyStore.family.orphans[index].speciality_type"
            :academic_level_id_field_name="`orphans.${index}.academic_level_id`"
            :birth_date_field_name="`orphans.${index}.birth_date`"
            :ccp_field_name="`orphans.${index}.ccp`"
            :form
            :institution_field_name="`orphans.${index}.institution_id`"
            :phone_number_field_name="`orphans.${index}.phone_number`"
            :vocational_training_id_field_name="`orphans.${index}.vocational_training_id`"
        ></the-academic-infos>

        <!-- Begin: if orphan is still baby-->
        <div v-if="isStillBaby" class="col-span-12 grid grid-cols-12 gap-4 gap-y-5">
            <!-- Begin: Baby Milk Type-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`baby_milk_type_${index}`">
                    {{ $t('baby_milk_type') }}
                </base-form-label>

                <the-baby-milk-selector
                    :id="`baby_milk_type_${index}`"
                    v-model:baby-milk="createFamilyStore.family.orphans[index].baby_milk_type"
                    @update:baby-milk="form?.validate(`orphans.${index}.baby_milk_type`)"
                ></the-baby-milk-selector>

                <base-form-input-error :field_name="`orphans.${index}.baby_milk_type`" :form></base-form-input-error>
            </div>
            <!-- End: Baby Milk Type-->

            <!-- Begin: Baby Milk Quantity-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`baby_milk_quantity_${index}`">
                    {{ $t('baby_milk_quantity_label') }}
                </base-form-label>

                <base-form-input
                    :id="`baby_milk_quantity_${index}`"
                    v-model="createFamilyStore.family.orphans[index].baby_milk_quantity"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('baby_milk_quantity')
                        })
                    "
                    type="number"
                    @change="form?.validate(`orphans.${index}.baby_milk_quantity`)"
                ></base-form-input>

                <base-form-input-error :field_name="`orphans.${index}.baby_milk_quantity`" :form>
                </base-form-input-error>
            </div>
            <!-- End: Baby Milk Quantity-->

            <!-- Begin: Diapers Type-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`diapers_type_${index}`">
                    {{ $t('diapers_type') }}
                </base-form-label>

                <the-diapers-selector
                    :id="`diapers_type_${index}`"
                    v-model:diaper="createFamilyStore.family.orphans[index].diapers_type"
                    @update:diaper="form?.validate(`orphans.${index}.diapers_type`)"
                ></the-diapers-selector>

                <base-form-input-error :field_name="`orphans.${index}.diapers_type`" :form></base-form-input-error>
            </div>
            <!-- End: Diapers Type-->

            <!-- Begin: Diapers Quantity-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`diapers_quantity_${index}`">
                    {{ $t('diapers_quantity_label') }}
                </base-form-label>

                <base-form-input
                    :id="`diapers_quantity_${index}`"
                    v-model="createFamilyStore.family.orphans[index].diapers_quantity"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('diapers_quantity')
                        })
                    "
                    type="number"
                    @change="form?.validate(`orphans.${index}.diapers_quantity`)"
                ></base-form-input>

                <base-form-input-error :field_name="`orphans.${index}.diapers_quantity`" :form></base-form-input-error>
            </div>
            <!-- End: Diapers Quantity-->
        </div>
        <!-- End: if orphan is still baby-->

        <!-- Begin: if orphan is adult-->
        <template v-else>
            <!-- Begin: Shoes Size-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`shoes_size_${index}`">
                    {{ $t('shoes_size') }}
                </base-form-label>

                <div>
                    <!-- @vue-ignore -->
                    <the-shoes-size-selector
                        :id="`shoes_size_${index}`"
                        v-model:size="createFamilyStore.family.orphans[index].shoes_size"
                        @update:size="
                            form?.validate(
                                //@ts-ignore
                                `orphans.${index}.shoes_size`
                            )
                        "
                    ></the-shoes-size-selector>
                </div>

                <base-form-input-error :field_name="`orphans.${index}.shoes_size`" :form></base-form-input-error>
            </div>
            <!-- End: Shoes Size-->

            <!-- Begin: Shirt Size-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`shirt_size_${index}`">
                    {{ $t('shirt_size') }}
                </base-form-label>

                <div>
                    <!-- @vue-ignore -->
                    <the-clothes-size-selector
                        :id="`shirt_size_${index}`"
                        v-model:size="createFamilyStore.family.orphans[index].shirt_size"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('shirt_size') })"
                        @update:size="
                            form?.validate(
                                //@ts-ignore
                                `orphans.${index}.shirt_size`
                            )
                        "
                    ></the-clothes-size-selector>
                </div>

                <base-form-input-error :field_name="`orphans.${index}.shirt_size`" :form></base-form-input-error>
            </div>
            <!-- End: Shirt Size-->

            <!-- Begin: Pants Size-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label :for="`pants_size_${index}`">
                    {{ $t('pants_size') }}
                </base-form-label>
                <div>
                    <!-- @vue-ignore -->
                    <the-clothes-size-selector
                        :id="`pants_size_${index}`"
                        v-model:size="createFamilyStore.family.orphans[index].pants_size"
                        @update:size="
                            form?.validate(
                                //@ts-ignore
                                `orphans.${index}.pants_size`
                            )
                        "
                    ></the-clothes-size-selector>
                </div>

                <base-form-input-error :field_name="`orphans.${index}.pants_size`" :form></base-form-input-error>
            </div>
            <!-- End: Pants Size-->
        </template>
        <!-- End: if orphan is adult-->

        <div class="col-span-12 grid grid-cols-12 gap-4 sm:col-span-6 sm:mt-8">
            <!--Begin: Handicapped-->
            <div class="col-span-6 sm:col-span-3">
                <base-form-switch class="text-lg">
                    <base-form-switch-input
                        :id="`is_handicapped_${index}`"
                        v-model="createFamilyStore.family.orphans[index].is_handicapped"
                        type="checkbox"
                    ></base-form-switch-input>

                    <base-form-switch-label :htmlFor="`is_handicapped_${index}`" class="whitespace-nowrap text-nowrap">
                        {{ $t('handicapped') }}
                    </base-form-switch-label>
                </base-form-switch>
            </div>
            <!--END: Handicapped-->

            <!--Begin: Unemployed-->
            <div v-if="isShouldHasUnemploymentBenefit" class="col-span-6 sm:col-span-3">
                <base-form-switch class="text-lg">
                    <base-form-switch-input
                        :id="`is_unemployed_${index}`"
                        v-model="createFamilyStore.family.orphans[index].is_unemployed"
                        type="checkbox"
                    ></base-form-switch-input>

                    <base-form-switch-label :htmlFor="`is_unemployed_${index}`" class="whitespace-nowrap text-nowrap">
                        {{ $t('unemployed') }}
                    </base-form-switch-label>
                </base-form-switch>
            </div>
            <!--END: Unemployed-->
        </div>

        <!-- Begin: Income-->
        <div v-if="isShouldHasIncome" class="col-span-12 sm:col-span-6">
            <base-form-label :for="`income_${index}`">
                {{ $t('validation.attributes.income') }}
            </base-form-label>

            <base-form-input
                :id="`income_${index}`"
                v-model="createFamilyStore.family.orphans[index].income"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.income')
                    })
                "
                data-test="orphan_income"
                type="text"
                @change="form?.validate(`orphans.${index}.income`)"
            ></base-form-input>

            <base-form-input-error :field_name="`orphans.${index}.income`" :form></base-form-input-error>
        </div>
        <!-- End: Income-->

        <!-- Begin: Note -->
        <div class="col-span-8">
            <base-form-label :for="`note_${index}`">
                {{ $t('notes') }}
            </base-form-label>

            <base-form-text-area
                :id="`note_${index}`"
                v-model="createFamilyStore.family.orphans[index].note"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('notes')
                    })
                "
                type="text"
                @change="form?.validate(`orphans.${index}.note`)"
            ></base-form-text-area>

            <base-form-input-error :field_name="`orphans.${index}.note`" :form></base-form-input-error>
        </div>
        <!-- End: Note -->

        <slot></slot>
    </div>
</template>
