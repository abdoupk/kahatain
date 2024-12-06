<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useSchoolsStore } from '@/stores/schools'
import { useVocationalTrainingStore } from '@/stores/voacational-training'
import { Form } from 'laravel-precognition-vue/dist/types'
import { computed, onMounted, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheInstitutionSelector from '@/Components/Global/TheInstitutionSelector.vue'
import TheVocationalTrainingSelector from '@/Components/Global/TheVocationalTrainingSelector.vue'

import { allowOnlyNumbersOnKeyDown, isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    birthDate: string | Date
    form: Form<unknown>
    birth_date_field_name: string
    ccp_field_name: string
    vocational_training_id_field_name: string
    academic_level_id_field_name: string
    institution_field_name: string
    phone_number_field_name: string
}>()

console.log(props.form.data())

const phase = ref('')

const academicLevelsStore = useAcademicLevelsStore()

const academicLevels = ref<AcademicLevelType[]>([])

const isAcademic = computed(() => {
    return phase.value === 'university'
})

const academicLevel = defineModel('academicLevel', { default: '' })

const shouldBeInSchool = computed(() => {
    return props.birthDate && isOlderThan(props.birthDate, 5)
})

const vocationalTraining = defineModel('vocationalTraining', { default: '' })

const institution = defineModel('institution', { default: '' })

const institutionType = defineModel('institutionType', { default: 'school' })

const phoneNumber = defineModel('phoneNumber', { default: '' })

const ccp = defineModel('ccp', { default: '' })

const institutionName = computed(() => {
    switch (phase.value) {
        case 'university':
            return $t('university')

        case 'vocational_training':
            return $t('vocational_training_center')

        case 'primary_education':
            return $t('primary_school')

        case 'secondary_education':
            return $t('secondary_school')

        case 'middle_education':
            return $t('middle_school')

        default:
            return $t('validation.attributes.institution')
    }
})

const handleUpdateAcademicLevel = (value: string) => {
    phase.value = academicLevelsStore.getPhaseFromId(value)

    institution.value = {
        id: '',
        name: ''
    }

    if (phase.value === 'vocational_training') {
        institutionType.value = 'vocational_training_center'
    }

    if (phase.value === 'university') {
        institutionType.value = 'university'
    }

    if (
        phase.value === 'primary_education' ||
        phase.value === 'secondary_education' ||
        phase.value === 'middle_education'
    ) {
        institutionType.value = 'school'
    }
}

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForOrphans()

    phase.value = academicLevelsStore.getPhaseFromId(academicLevel.value)
})

const schoolsStore = useSchoolsStore()

function loadSchools(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    schoolsStore.searchSchools(query, phase.value).then((results) => {
        setOptions(results)
    })
}

function loadUniversities(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    schoolsStore.searchUniversities(query).then((results) => {
        setOptions(results)
    })
}

function loadVocationalTrainingCenters(query: string, setOptions: (results: { id: string; name: string }[]) => void) {
    useVocationalTrainingStore()
        .searchVocationalTrainingCenters(query)
        .then((results) => {
            setOptions(results)
        })
}
</script>

<template>
    <template v-if="shouldBeInSchool">
        <!-- Begin: Academic Level-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="academic_level_id_field_name">
                {{ $t('validation.attributes.sponsor.academic_level') }}
            </base-form-label>

            <div>
                <the-academic-level-selector
                    :id="academic_level_id_field_name"
                    v-model:academic-level="academicLevel"
                    :academic-levels="academicLevels"
                    @update:academic-level="handleUpdateAcademicLevel"
                ></the-academic-level-selector>
            </div>

            <base-form-input-error :field_name="academic_level_id_field_name" :form></base-form-input-error>
        </div>
        <!-- End: Academic Level-->

        <!-- Begin: Institution-->
        <div v-if="phase !== 'other'" class="col-span-12 sm:col-span-6">
            <base-form-label :for="institution_field_name">
                {{ institutionName }}
            </base-form-label>

            <the-institution-selector
                v-if="isAcademic"
                :id="institution_field_name"
                v-model:value="institution"
                :load-options="loadUniversities"
                :phase-key="phase"
                class="!mt-0"
            ></the-institution-selector>

            <the-institution-selector
                v-else-if="phase === 'vocational_training'"
                :id="institution_field_name"
                v-model:value="institution"
                :load-options="loadVocationalTrainingCenters"
                :phase-key="phase"
                class="!mt-0"
            ></the-institution-selector>

            <the-institution-selector
                v-else
                :id="institution_field_name"
                v-model:value="institution"
                :load-options="loadSchools"
                :phase-key="phase"
                class="!mt-0"
            ></the-institution-selector>

            <base-form-input-error :field_name="institution_field_name" :form></base-form-input-error>
        </div>
        <!-- End: Institution-->
    </template>

    <!-- Begin: Vocational Training-->
    <div v-if="phase === 'vocational_training'" class="col-span-12 sm:col-span-6">
        <base-form-label :for="vocational_training_id_field_name">
            {{ $t('speciality') }}
        </base-form-label>

        <div>
            <the-vocational-training-selector
                :id="vocational_training_id_field_name"
                v-model:vocational-training="vocationalTraining"
            ></the-vocational-training-selector>
        </div>

        <base-form-input-error :field_name="vocational_training_id_field_name" :form></base-form-input-error>
    </div>
    <!-- End: Vocational Training-->

    <!-- Begin: if orphan is academic -->
    <template v-if="isAcademic">
        <!-- Begin: CCp-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="ccp_field_name">
                {{ $t('ccp') }}
            </base-form-label>

            <base-form-input
                :id="ccp_field_name"
                v-model="ccp"
                :placeholder="$t('auth.placeholders.fill', { attribute: $t('ccp') })"
                maxlength="12"
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error :field_name="ccp_field_name" :form></base-form-input-error>
        </div>
        <!-- End: CCp-->

        <!-- Begin: Phone Number-->
        <div class="col-span-12 sm:col-span-6">
            <base-form-label :for="phone_number_field_name">
                {{ $t('validation.attributes.phone_number') }}
            </base-form-label>

            <base-form-input
                :id="phone_number_field_name"
                v-model="phoneNumber"
                :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.phone_number') })"
                maxlength="10"
                @keydown="allowOnlyNumbersOnKeyDown"
            ></base-form-input>

            <base-form-input-error :field_name="phone_number_field_name" :form></base-form-input-error>
        </div>
        <!-- End: Phone Number-->
    </template>
    <!-- End: if orphan is academic -->
</template>
