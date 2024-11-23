<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'
import type { CreateFamilyForm } from '@/types/types'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useCreateFamilyStore } from '@/stores/create-family'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { computed, onMounted, ref } from 'vue'

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
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheBabyMilkSelector from '@/Components/Global/TheBabyMilkSelector.vue'
import TheClothesSizeSelector from '@/Components/Global/TheClothesSizeSelector.vue'
import TheDiapersSelector from '@/Components/Global/TheDiapersSelector.vue'
import TheFamilyStatusSelector from '@/Components/Global/TheFamilyStatusSelector.vue'
import TheInstitutionSelector from '@/Components/Global/TheInstitutionSelector.vue'
import TheShoesSizeSelector from '@/Components/Global/TheShoesSizeSelector.vue'
import TheVocationalTrainingSelector from '@/Components/Global/TheVocationalTrainingSelector.vue'

import { allowOnlyNumbersOnKeyDown, isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    form: Form<CreateFamilyForm>
    index: number
}>()

const createFamilyStore = useCreateFamilyStore()

// TODO: fix this when add new orphan change focus

const phase = ref()

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

    return (
        !createFamilyStore.family.orphans[props.index].is_handicapped &&
        !createFamilyStore.family.orphans[props.index].is_unemployed
    )
})

const isAcademic = computed(() => {
    return phase.value === 'الطور الجامعي'
})

const academicLevelsStore = useAcademicLevelsStore()

const shouldBeInSchool = computed(() => {
    return (
        createFamilyStore.family.orphans[props.index].birth_date &&
        isOlderThan(createFamilyStore.family.orphans[props.index].birth_date, 5)
    )
})

const academicLevels = ref<AcademicLevelType[]>([])

const pic = props.form?.orphans[props.index]?.photo

onMounted(async () => {
    document.getElementById(`first_name_${props.index}`)?.focus()

    academicLevels.value = await academicLevelsStore.getAcademicLevelsForOrphans()
})

const handleUpdateAcademicLevel = (value: number) => {
    phase.value = academicLevelsStore.getPhaseFromId(value)

    // @ts-ignore
    props.form?.validate(`orphans.${props.index}.academic_level_id`)
}

const handleUpdateInstitution = (value: number) => {
    phase.value = academicLevelsStore.getPhaseFromId(value)

    // @ts-ignore
    props.form?.validate(`orphans.${props.index}.institution`)
}
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

        <!-- Begin: First Name-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="first_name">
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

        <!-- Begin: Last Name-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="last_name">
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

        <!-- Begin: Birth Date-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="orphans.birth_date">
                {{ $t('validation.attributes.date_of_birth') }}
            </base-form-label>

            <base-v-calendar v-model:date="createFamilyStore.family.orphans[index].birth_date"></base-v-calendar>

            <base-form-input-error :field_name="`orphans.${index}.birth_date`" :form></base-form-input-error>
        </div>
        <!-- End: Birth Date-->

        <!-- Begin: Gender-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="orphans.gender">
                {{ $t('validation.attributes.date_of_birth') }}
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
            <base-form-label for="health_status">
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
            <base-form-label for="family_status">
                {{ $t('family_status') }}
            </base-form-label>

            <div>
                <the-family-status-selector
                    :id="`family_status_${index}`"
                    v-model:family-status="createFamilyStore.family.orphans[index].family_status"
                    @update:family-status="form?.validate(`orphans.${index}.family_status`)"
                ></the-family-status-selector>
            </div>

            <base-form-input-error :field_name="`orphans.${index}.family_status`" :form></base-form-input-error>
        </div>
        <!-- End: Family Status-->

        <template v-if="shouldBeInSchool">
            <!-- Begin: Academic Level-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="academic_level">
                    {{ $t('validation.attributes.sponsor.academic_level') }}
                </base-form-label>

                <div>
                    <the-academic-level-selector
                        :id="`academic_level_${index}`"
                        v-model:academic-level="createFamilyStore.family.orphans[index].academic_level_id"
                        :academic-levels="academicLevels"
                        @update:academic-level="handleUpdateAcademicLevel"
                    ></the-academic-level-selector>
                </div>

                <base-form-input-error :field_name="`orphans.${index}.academic_level_id`" :form></base-form-input-error>
            </div>
            <!-- End: Academic Level-->

            <!-- Begin: Institution-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="institution">
                    {{ $t('validation.attributes.institution') }}
                </base-form-label>

                <div>
                    <the-institution-selector
                        :id="`institution_${index}`"
                        v-model:academic-level="createFamilyStore.family.orphans[index].institution_id"
                        :academic-levels="academicLevels"
                        @update:academic-level="handleUpdateInstitution"
                    ></the-institution-selector>
                </div>

                <base-form-input-error :field_name="`orphans.${index}.institution_id`" :form></base-form-input-error>
            </div>
            <!-- End: Institution-->
        </template>

        <!-- Begin: Vocational Training-->
        <div v-if="phase === 'التكوين المهني'" class="col-span-12 sm:col-span-6">
            <base-form-label :for="`vocational_training_id_${index}`">
                {{ $t('speciality') }}
            </base-form-label>

            <div>
                <the-vocational-training-selector
                    :id="`vocational_training_id_${index}`"
                    v-model:vocational-training="createFamilyStore.family.orphans[index].vocational_training_id"
                    @update:vocational-training="() => form?.validate(`orphans.${index}.vocational_training_id`)"
                ></the-vocational-training-selector>
            </div>

            <base-form-input-error :field_name="`orphans.${index}.vocational_training_id`" :form>
            </base-form-input-error>
        </div>
        <!-- End: Vocational Training-->

        <!-- Begin: if orphan is academic -->
        <template v-if="isAcademic">
            <!-- Begin: CCp-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="ccp">
                    {{ $t('ccp') }}
                </base-form-label>

                <base-form-input
                    :id="`ccp_${index}`"
                    v-model="createFamilyStore.family.orphans[index].ccp"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('ccp') })"
                    maxlength="12"
                    @keydown="allowOnlyNumbersOnKeyDown"
                    @update:model-value="form?.validate(`orphans.${index}.ccp`)"
                ></base-form-input>

                <base-form-input-error :field_name="`orphans.${index}.ccp`" :form></base-form-input-error>
            </div>
            <!-- End: CCp-->

            <!-- Begin: Phone Number-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="phone_number">
                    {{ $t('validation.attributes.phone_number') }}
                </base-form-label>

                <base-form-input
                    :id="`phone_number_${index}`"
                    v-model="createFamilyStore.family.orphans[index].phone_number"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.phone_number') })"
                    maxlength="10"
                    @keydown="allowOnlyNumbersOnKeyDown"
                    @update:model-value="form?.validate(`orphans.${index}.phone_number`)"
                ></base-form-input>

                <base-form-input-error :field_name="`orphans.${index}.phone_number`" :form></base-form-input-error>
            </div>
            <!-- End: Phone Number-->
        </template>
        <!-- End: if orphan is academic -->

        <!-- Begin: if orphan is still baby-->
        <div v-if="isStillBaby" class="col-span-12 grid grid-cols-12 gap-4 gap-y-5">
            <!-- Begin: Baby Milk Type-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="baby_milk_type">
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
                <base-form-label for="baby_milk_quantity">
                    {{ $t('baby_milk_quantity') }}
                </base-form-label>

                <base-form-input
                    :id="`baby_milk_quantity_${index}`"
                    v-model="createFamilyStore.family.orphans[index].baby_milk_quantity"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('baby_milk_quantity')
                        })
                    "
                    type="text"
                    @change="form?.validate(`orphans.${index}.baby_milk_quantity`)"
                ></base-form-input>

                <base-form-input-error :field_name="`orphans.${index}.baby_milk_quantity`" :form>
                </base-form-input-error>
            </div>
            <!-- End: Baby Milk Quantity-->

            <!-- Begin: Diapers Type-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="diapers_type">
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
                <base-form-label for="diapers_quantity">
                    {{ $t('diapers_quantity') }}
                </base-form-label>

                <base-form-input
                    :id="`diapers_quantity_${index}`"
                    v-model="createFamilyStore.family.orphans[index].diapers_quantity"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('diapers_quantity')
                        })
                    "
                    type="text"
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
                <base-form-label for="shoes_size">
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
                <base-form-label for="shirt_size">
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
                <base-form-label for="pants_size">
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
                        id="is_handicapped"
                        v-model="createFamilyStore.family.orphans[index].is_handicapped"
                        type="checkbox"
                    ></base-form-switch-input>

                    <base-form-switch-label class="whitespace-nowrap text-nowrap" htmlFor="is_handicapped">
                        {{ $t('handicapped') }}
                    </base-form-switch-label>
                </base-form-switch>
            </div>
            <!--END: Handicapped-->

            <!--Begin: Unemployed-->
            <div v-if="isOlderThan18" class="col-span-6 sm:col-span-3">
                <base-form-switch class="text-lg">
                    <base-form-switch-input
                        id="is_unemployed"
                        v-model="createFamilyStore.family.orphans[index].is_unemployed"
                        type="checkbox"
                    ></base-form-switch-input>

                    <base-form-switch-label class="whitespace-nowrap text-nowrap" htmlFor="is_unemployed">
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
