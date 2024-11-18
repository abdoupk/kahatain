<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'
import type { CreateFamilyForm } from '@/types/types'

import { useAcademicLevelsStore } from '@/stores/academic-level'
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
import TheShoesSizeSelector from '@/Components/Global/TheShoesSizeSelector.vue'
import TheVocationalTrainingSelector from '@/Components/Global/TheVocationalTrainingSelector.vue'

import { isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    form: Form<CreateFamilyForm>
    index: number
}>()

// TODO: fix this when add new orphan change focus

const phase = ref()

const firstName = defineModel('first_name', { default: '' })

const lastName = defineModel('last_name')

const academicLevel = defineModel<{ id: number; name: string }>('academicLevel')

const income = defineModel('income')

const vocationalTraining = defineModel('vocational_training')

const healthStatus = defineModel('health_status')

const familyStatus = defineModel('family_status')

const shoesSize = defineModel('shoesSize')

const pantsSize = defineModel('pantsSize')

const shirtSize = defineModel('shirtSize')

const note = defineModel('note')

const isHandicapped = defineModel('isHandicapped')

const isUnemployed = defineModel('isUnemployed')

const babyMilkQuantity = defineModel('babyMilkQuantity')

const gender = defineModel('gender')

const babyMilkType = defineModel<string | undefined>('babyMilkType')

const diapersType = defineModel<string | undefined>('diapersType')

const diapersQuantity = defineModel('diapersQuantity')

const birthDate = defineModel('birth_date', { default: '' })

const photo = defineModel('photo', { default: '' })

const isStillBaby = computed(() => {
    return birthDate.value && !isOlderThan(birthDate.value, 2)
})

const isOlderThan18 = computed(() => {
    return birthDate.value && isOlderThan(birthDate.value, 18)
})

const isShouldHasIncome = computed(() => {
    if (!isOlderThan18.value) return false

    return !isHandicapped.value && !isUnemployed.value
})

const academicLevelsStore = useAcademicLevelsStore()

const shouldBeInSchool = computed(() => {
    return birthDate.value && isOlderThan(birthDate.value, 5)
})

const academicLevels = ref<AcademicLevelType[]>([])

const pic = ref(props.form?.orphans[props.index]?.photo)

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForOrphans()
})

const handleUpdateAcademicLevel = (value: number) => {
    phase.value = academicLevelsStore.getPhaseFromId(value)

    // @ts-ignore
    props.form?.validate(`orphans.${props.index}.academic_level_id`)
}

const handleUpdateVocationalTraining = () => {
    // @ts-ignore
    props.form?.validate(`orphans.${props.index}.vocational_training_id`)
}
</script>

<template>
    <div class="grid grid-cols-12 gap-4 gap-y-5 border-2 border-dashed px-2 pb-2.5 pt-2">
        <!-- Begin: Photo-->
        <div class="col-span-12">
            <div class="me-2 ms-auto mt-2 h-36 w-36">
                <base-file-pond
                    :labelIdle="$t('upload-files.labelIdle.orphan_photo')"
                    :id="`photo_${index}`"
                    :key="`photo_${index}`"
                    :allow-multiple="false"
                    :files="pic"
                    is-picture
                    @update:files="photo = $event[0]"
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
                v-model="firstName"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.first_name')
                    })
                "
                data-test="orphan_first_name"
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        `orphans.${index}.first_name`
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.first_name`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_first_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.first_name`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: First Name-->

        <!-- Begin: Last Name-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="last_name">
                {{ $t('validation.attributes.last_name') }}
            </base-form-label>

            <base-form-input
                :id="`last_name_${index}`"
                v-model="lastName"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.last_name')
                    })
                "
                data-test="orphan_last_name"
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        `orphans.${index}.last_name`
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.last_name`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_last_name_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.last_name`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Last Name-->

        <!-- Begin: Birth Date-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="orphans.birth_date">
                {{ $t('validation.attributes.date_of_birth') }}
            </base-form-label>

            <base-v-calendar v-model:date="birthDate"></base-v-calendar>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.birth_date`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_start_date_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.birth_date`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Birth Date-->

        <!-- Begin: Gender-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="orphans.gender">
                {{ $t('validation.attributes.date_of_birth') }}
            </base-form-label>

            <base-form-select
                :id="`gender_${index}`"
                v-model="gender"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.gender')
                    })
                "
                data-test="orphan_gender"
                @change="
                    form?.validate(
                        //@ts-ignore
                        `orphans.${index}.gender`
                    )
                "
            >
                <option value="male">{{ $t('male') }}</option>

                <option value="female">{{ $t('female') }}</option>
            </base-form-select>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.gender`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_gender_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.gender`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Gender-->

        <!-- Begin: Health Status-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="health_status">
                {{ $t('validation.attributes.sponsor.health_status') }}
            </base-form-label>

            <base-form-input
                :id="`health_status_${index}`"
                v-model="healthStatus"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.sponsor.health_status')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        `orphans.${index}.health_status`
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.health_status`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_health_status_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.health_status`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Health Status-->

        <!-- Begin: Family Status-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label for="family_status">
                {{ $t('family_status') }}
            </base-form-label>

            <div>
                <the-family-status-selector
                    :id="`family_status_${index}`"
                    v-model:family-status="familyStatus"
                    @update:family-status="
                        form?.validate(
                            //@ts-ignore
                            `orphans.${index}.family_status`
                        )
                    "
                ></the-family-status-selector>
            </div>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.family_status`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_family_status_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.family_status`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Family Status-->

        <!-- Begin: Academic Level-->
        <div v-if="shouldBeInSchool" class="col-span-12 sm:col-span-6">
            <base-form-label for="academic_level">
                {{ $t('validation.attributes.sponsor.academic_level') }}
            </base-form-label>

            <div>
                <the-academic-level-selector
                    :id="`academic_level_${index}`"
                    v-model:academic-level="academicLevel"
                    :academic-levels="academicLevels"
                    @update:academic-level="handleUpdateAcademicLevel"
                ></the-academic-level-selector>
            </div>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.academic_level_id`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_academic_level_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.academic_level_id`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Academic Level-->

        <!-- Begin: Vocational Training-->
        <div v-if="phase === 'التكوين المهني'" class="col-span-12 sm:col-span-6">
            <base-form-label :for="`vocational_training_id_${index}`">
                {{ $t('speciality') }}
            </base-form-label>

            <div>
                <the-vocational-training-selector
                    :id="`vocational_training_id_${index}`"
                    v-model:vocational-training="vocationalTraining"
                    @update:vocational-training="handleUpdateVocationalTraining"
                ></the-vocational-training-selector>
            </div>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.vocational_training_id`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_vocational_training_id_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.vocational_training_id`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Vocational Training-->

        <!-- Begin: if orphan is still baby-->
        <div v-if="isStillBaby" class="col-span-12 grid grid-cols-12 gap-4 gap-y-5">
            <!-- Begin: Baby Milk Type-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="baby_milk_type">
                    {{ $t('baby_milk_type') }}
                </base-form-label>

                <the-baby-milk-selector
                    :id="`baby_milk_type_${index}`"
                    v-model:baby-milk="babyMilkType"
                    @update:baby-milk="
                        form?.validate(
                            //@ts-ignore
                            `orphans.${index}.baby_milk_type`
                        )
                    "
                ></the-baby-milk-selector>

                <base-form-input-error>
                    <div
                        v-if="
                            form?.invalid(
                                //@ts-ignore
                                `orphans.${index}.baby_milk_type`
                            )
                        "
                        class="mt-2 text-danger"
                        data-test="error_baby_milk_type_message"
                    >
                        {{
                            //@ts-ignore
                            form.errors[`orphans.${index}.baby_milk_type`]
                        }}
                    </div>
                </base-form-input-error>
            </div>
            <!-- End: Baby Milk Type-->

            <!-- Begin: Baby Milk Quantity-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="baby_milk_quantity">
                    {{ $t('baby_milk_quantity') }}
                </base-form-label>

                <base-form-input
                    :id="`baby_milk_quantity_${index}`"
                    v-model="babyMilkQuantity"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('baby_milk_quantity')
                        })
                    "
                    type="text"
                    @change="
                        form?.validate(
                            //@ts-ignore
                            `orphans.${index}.baby_milk_quantity`
                        )
                    "
                ></base-form-input>

                <base-form-input-error>
                    <div
                        v-if="
                            form?.invalid(
                                //@ts-ignore
                                `orphans.${index}.baby_milk_quantity`
                            )
                        "
                        class="mt-2 text-danger"
                        data-test="error_baby_milk_quantity_message"
                    >
                        {{
                            //@ts-ignore
                            form.errors[`orphans.${index}.baby_milk_quantity`]
                        }}
                    </div>
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
                    v-model:diaper="diapersType"
                    @update:diaper="
                        form?.validate(
                            //@ts-ignore
                            `orphans.${index}.diapers_type`
                        )
                    "
                ></the-diapers-selector>

                <base-form-input-error>
                    <div
                        v-if="
                            form?.invalid(
                                //@ts-ignore
                                `orphans.${index}.diapers_type`
                            )
                        "
                        class="mt-2 text-danger"
                        data-test="error_diapers_type_message"
                    >
                        {{
                            //@ts-ignore
                            form.errors[`orphans.${index}.diapers_type`]
                        }}
                    </div>
                </base-form-input-error>
            </div>
            <!-- End: Diapers Type-->

            <!-- Begin: Diapers Quantity-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label for="diapers_quantity">
                    {{ $t('diapers_quantity') }}
                </base-form-label>

                <base-form-input
                    :id="`diapers_quantity_${index}`"
                    v-model="diapersQuantity"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('diapers_quantity')
                        })
                    "
                    type="text"
                    @change="
                        form?.validate(
                            //@ts-ignore
                            `orphans.${index}.diapers_quantity`
                        )
                    "
                ></base-form-input>

                <base-form-input-error>
                    <div
                        v-if="
                            form?.invalid(
                                //@ts-ignore
                                `orphans.${index}.diapers_quantity`
                            )
                        "
                        class="mt-2 text-danger"
                        data-test="error_diapers_quantity_message"
                    >
                        {{
                            //@ts-ignore
                            form.errors[`orphans.${index}.diapers_quantity`]
                        }}
                    </div>
                </base-form-input-error>
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
                        v-model:size="shoesSize"
                        @update:size="
                            form?.validate(
                                //@ts-ignore
                                `orphans.${index}.shoes_size`
                            )
                        "
                    ></the-shoes-size-selector>
                </div>

                <base-form-input-error>
                    <div
                        v-if="
                            form?.invalid(
                                //@ts-ignore
                                `orphans.${index}.shoes_size`
                            )
                        "
                        class="mt-2 text-danger"
                        data-test="error_shoes_size_message"
                    >
                        {{
                            //@ts-ignore
                            form.errors[`orphans.${index}.shoes_size`]
                        }}
                    </div>
                </base-form-input-error>
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
                        v-model:size="shirtSize"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('shirt_size') })"
                        @update:size="
                            form?.validate(
                                //@ts-ignore
                                `orphans.${index}.shirt_size`
                            )
                        "
                    ></the-clothes-size-selector>
                </div>

                <base-form-input-error>
                    <div
                        v-if="
                            form?.invalid(
                                //@ts-ignore
                                `orphans.${index}.shirt_size`
                            )
                        "
                        class="mt-2 text-danger"
                        data-test="error_shirt_size_message"
                    >
                        {{
                            //@ts-ignore
                            form.errors[`orphans.${index}.shirt_size`]
                        }}
                    </div>
                </base-form-input-error>
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
                        v-model:size="pantsSize"
                        @update:size="
                            form?.validate(
                                //@ts-ignore
                                `orphans.${index}.pants_size`
                            )
                        "
                    ></the-clothes-size-selector>
                </div>

                <base-form-input-error>
                    <div
                        v-if="
                            form?.invalid(
                                //@ts-ignore
                                `orphans.${index}.pants_size`
                            )
                        "
                        class="mt-2 text-danger"
                        data-test="error_pants_size_message"
                    >
                        {{
                            //@ts-ignore
                            form.errors[`orphans.${index}.pants_size`]
                        }}
                    </div>
                </base-form-input-error>
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
                        v-model="isHandicapped"
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
                        v-model="isUnemployed"
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
                v-model="income"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('validation.attributes.income')
                    })
                "
                data-test="orphan_income"
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        `orphans.${index}.income`
                    )
                "
            ></base-form-input>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.income`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_income_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.income`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Income-->

        <!-- Begin: Note -->
        <div class="col-span-8">
            <base-form-label :for="`note_${index}`">
                {{ $t('notes') }}
            </base-form-label>

            <base-form-text-area
                :id="`note_${index}`"
                v-model="note"
                :placeholder="
                    $t('auth.placeholders.fill', {
                        attribute: $t('notes')
                    })
                "
                type="text"
                @change="
                    form?.validate(
                        //@ts-ignore
                        `orphans.${index}.note`
                    )
                "
            ></base-form-text-area>

            <base-form-input-error>
                <div
                    v-if="
                        form?.invalid(
                            //@ts-ignore
                            `orphans.${index}.note`
                        )
                    "
                    class="mt-2 text-danger"
                    data-test="error_note_message"
                >
                    {{
                        //@ts-ignore
                        form.errors[`orphans.${index}.note`]
                    }}
                </div>
            </base-form-input-error>
        </div>
        <!-- End: Note -->

        <slot></slot>
    </div>
</template>
