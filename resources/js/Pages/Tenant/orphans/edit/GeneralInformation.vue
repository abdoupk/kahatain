<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'
import type { OrphanUpdateFormType } from '@/types/orphans'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useForm } from 'laravel-precognition-vue'
import { onMounted, reactive, ref } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheBabyMilkSelector from '@/Components/Global/TheBabyMilkSelector.vue'
import TheClothesSizeSelector from '@/Components/Global/TheClothesSizeSelector.vue'
import TheDiapersSelector from '@/Components/Global/TheDiapersSelector.vue'
import TheFamilyStatusSelector from '@/Components/Global/TheFamilyStatusSelector.vue'
import TheShoesSizeSelector from '@/Components/Global/TheShoesSizeSelector.vue'

import { isOlderThan, omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    orphan: OrphanUpdateFormType
}>()

const emit = defineEmits(['orphan-updated'])

// eslint-disable-next-line array-element-newline
const inputs = reactive<OrphanUpdateFormType>(
    // eslint-disable-next-line array-element-newline
    omit(props.orphan, [
        'sponsorships',
        'vocational_training_achievements',
        'last_academic_year_achievement',
        'academic_achievements',
        'college_achievements',
        'id',
        'creator'
    ])
)

const form = useForm('put', route('tenant.orphans.infos-update', props.orphan.id), inputs)

const updateSuccess = ref(false)

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
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('display information') }}</h2>
        </div>

        <form @submit.prevent="submit">
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

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('first_name')"
                            class="mt-2 text-danger"
                            data-test="error_first_name_message"
                        >
                            {{ form.errors.first_name }}
                        </div>
                    </base-form-input-error>
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

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('last_name')"
                            class="mt-2 text-danger"
                            data-test="error_last_name_message"
                        >
                            {{ form.errors.last_name }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Last Name -->

                <!-- BEGIN: BirthDate -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="birth_date">
                        {{ $t('validation.attributes.spouse.birth_date') }}
                    </base-form-label>

                    <base-v-calendar v-model:date="form.birth_date"></base-v-calendar>
                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('birth_date')"
                            class="mt-2 text-danger"
                            data-test="error_birth_date_message"
                        >
                            {{ form.errors.birth_date }}
                        </div>
                    </base-form-input-error>
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
                        @update:family-status="form?.validate(`family_status`)"
                    >
                    </the-family-status-selector>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('family_status')"
                            class="mt-2 text-danger"
                            data-test="error_family_status_message"
                        >
                            {{ form.errors.family_status }}
                        </div>
                    </base-form-input-error>
                </div>
                <!-- END: Family Status -->

                <!-- BEGIN: Academic Level -->
                <div class="col-span-12 @xl:col-span-6">
                    <base-form-label for="academic_level_id">
                        {{ $t('academic_level') }}
                    </base-form-label>

                    <div>
                        <the-academic-level-selector
                            id="academic_level_id"
                            v-model:academic-level="form.academic_level_id"
                            :academicLevels
                        ></the-academic-level-selector>
                    </div>

                    <base-form-input-error>
                        <div
                            v-if="form?.invalid('academic_level_id')"
                            class="mt-2 text-danger"
                            data-test="error_academic_level_message"
                        >
                            {{ form.errors.academic_level_id }}
                        </div>
                    </base-form-input-error>
                </div>
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

                    <base-form-input-error>
                        <div v-if="form?.invalid('gender')" class="mt-2 text-danger" data-test="error_gender_message">
                            {{ form.errors.gender }}
                        </div>
                    </base-form-input-error>
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

                        <base-form-input-error>
                            <div
                                v-if="form?.invalid('pants_size')"
                                class="mt-2 text-danger"
                                data-test="error_pants_size_message"
                            >
                                {{ form.errors.pants_size }}
                            </div>
                        </base-form-input-error>
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

                        <base-form-input-error>
                            <div
                                v-if="form?.invalid('shirt_size')"
                                class="mt-2 text-danger"
                                data-test="error_shirt_size_message"
                            >
                                {{ form.errors.shirt_size }}
                            </div>
                        </base-form-input-error>
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

                        <base-form-input-error>
                            <div
                                v-if="form?.invalid('shoes_size')"
                                class="mt-2 text-danger"
                                data-test="error_shoes_size_message"
                            >
                                {{ form.errors.shoes_size }}
                            </div>
                        </base-form-input-error>
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

                        <base-form-input-error>
                            <div
                                v-if="form?.invalid('diapers_type')"
                                class="mt-2 text-danger"
                                data-test="error_diapers_type_message"
                            >
                                {{ form.errors.diapers_type }}
                            </div>
                        </base-form-input-error>
                    </div>
                    <!-- END: Diapers Type -->

                    <!-- BEGIN: Diapers Quantity -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="diapers_quantity">
                            {{ $t('diapers_quantity') }}
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

                        <base-form-input-error>
                            <div
                                v-if="form?.invalid('diapers_quantity')"
                                class="mt-2 text-danger"
                                data-test="error_diapers_quantity_message"
                            >
                                {{ form.errors.diapers_quantity }}
                            </div>
                        </base-form-input-error>
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

                        <base-form-input-error>
                            <div
                                v-if="form?.invalid('baby_milk_type')"
                                class="mt-2 text-danger"
                                data-test="error_baby_milk_type_message"
                            >
                                {{ form.errors.baby_milk_type }}
                            </div>
                        </base-form-input-error>
                    </div>
                    <!-- END: Baby Milk Type -->

                    <!-- BEGIN: Baby Milk Quantity -->
                    <div class="col-span-12 @xl:col-span-6">
                        <base-form-label for="baby_milk_quantity">
                            {{ $t('baby_milk_quantity') }}
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

                        <base-form-input-error>
                            <div
                                v-if="form?.invalid('baby_milk_quantity')"
                                class="mt-2 text-danger"
                                data-test="error_baby_milk_quantity_message"
                            >
                                {{ form.errors.baby_milk_quantity }}
                            </div>
                        </base-form-input-error>
                    </div>
                    <!-- END: Baby Milk Quantity -->
                </template>

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

                    <base-form-input-error>
                        <div v-if="form?.invalid('note')" class="mt-2 text-danger" data-test="error_note_message">
                            {{ form.errors.note }}
                        </div>
                    </base-form-input-error>
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
