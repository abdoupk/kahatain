<script lang="ts" setup>
import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useCollegeAchievementsStore } from '@/stores/college-achievement'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, onMounted, ref } from 'vue'

import { $t, $tc } from '@/utils/i18n'

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInputError.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseFormSelect = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormSelect.vue'))

const BaseFormTextArea = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormTextArea.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const TheAcademicLevelSelector = defineAsyncComponent(() => import('@/Components/Global/TheAcademicLevelSelector.vue'))

defineProps<{
    open: boolean
}>()

// Get the collegeAchievement store
const collegeAchievementStore = useCollegeAchievementsStore()

// Initialize a ref for loading state
const loading = ref(false)

const form = computed(() => {
    if (collegeAchievementStore.collegeAchievement.id) {
        return useForm(
            'put',
            route('tenant.college-achievements.update', collegeAchievementStore.collegeAchievement.id),
            { ...collegeAchievementStore.collegeAchievement }
        )
    }

    return useForm('post', route('tenant.college-achievements.store'), {
        ...collegeAchievementStore.collegeAchievement
    })
})

const currentYear = new Date().getFullYear(),
    years = Array(11)
        .fill(0)
        .map((_, i) => currentYear + (i - 10))

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        // TODO change Route
        router.get(
            route('tenant.orphans.edit', collegeAchievementStore.collegeAchievement.orphan_id),
            {},
            {
                only: ['orphan']
            }
        )
    }, 200)

    emit('close')
}

// Function to handle form submission
const handleSubmit = async () => {
    loading.value = true

    try {
        await form.value.submit().then(handleSuccess)
    } finally {
        loading.value = false
    }
}

// Compute the slideover title based on the school id
const modalTitle = computed(() => {
    return collegeAchievementStore.collegeAchievement.id
        ? $t('modal_update_title', { attribute: $t('the_college_achievement') })
        : $tc('add new', 1, { attribute: $t('the_college_achievement') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the school id
const modalType = computed(() => {
    return collegeAchievementStore.collegeAchievement.id ? 'update' : 'create'
})

const academicLevels = ref([])

const academicLevelsStore = useAcademicLevelsStore()

onMounted(async () => {
    await academicLevelsStore.getAcademicLevelsForOrphansForSelectCollege().then((res) => {
        academicLevels.value = res
    })
})
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :modal-type="modalType"
        :open
        :title="modalTitle"
        size="xl"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <!-- Begin: Academic Level-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="academic_level_id">
                    {{ $t('validation.attributes.academic_level_id') }}
                </base-form-label>

                <div>
                    <the-academic-level-selector
                        id="academic_level_id"
                        v-model:academic-level="form.academic_level_id"
                        :academicLevels
                    ></the-academic-level-selector>
                </div>

                <div v-if="form.errors?.academic_level_id" class="mt-2">
                    <base-input-error :message="form.errors.academic_level_id"></base-input-error>
                </div>
            </div>
            <!-- End: Academic Level-->

            <!-- Begin: Speciality-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="speciality">
                    {{ $t('speciality') }}
                </base-form-label>

                <base-form-input
                    id="speciality"
                    v-model="form.speciality"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('speciality') })"
                    type="text"
                    @change="form.validate('speciality')"
                ></base-form-input>

                <div v-if="form.errors?.speciality" class="mt-2">
                    <base-input-error :message="form.errors.speciality"></base-input-error>
                </div>
            </div>
            <!-- End: Speciality-->

            <!-- Begin: University-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="university">
                    {{ $t('university') }}
                </base-form-label>

                <base-form-input
                    id="university"
                    v-model="form.university"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('university') })"
                    type="text"
                    @change="form.validate('university')"
                ></base-form-input>

                <div v-if="form.errors?.university" class="mt-2">
                    <base-input-error :message="form.errors.university"></base-input-error>
                </div>
            </div>
            <!-- End: University-->

            <!-- Begin: Academic Year-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="college_year">
                    {{ $t('academic_year') }}
                </base-form-label>

                <base-form-select id="college_year" v-model="form.year" @change="form.validate('year')">
                    <option v-for="year in years" :key="year" :value="year">
                        {{ year }}
                    </option>
                </base-form-select>

                <div v-if="form.errors?.year" class="mt-2">
                    <base-input-error :message="form.errors.year"></base-input-error>
                </div>
            </div>
            <!-- End: Academic Year-->

            <!-- Begin: First Semester-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="first_semester">
                    {{ $t('validation.attributes.first_semester') }}
                </base-form-label>

                <base-form-input
                    id="first_semester"
                    v-model="form.first_semester"
                    :placeholder="
                        $t('auth.placeholders.fill', { attribute: $t('validation.attributes.first_semester') })
                    "
                    step="0.01"
                    type="number"
                    @change="form.validate('first_semester')"
                ></base-form-input>

                <div v-if="form.errors?.first_semester" class="mt-2">
                    <base-input-error :message="form.errors.first_semester"></base-input-error>
                </div>
            </div>
            <!-- End: First Semester-->

            <!-- Begin: Second Semester-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="second_trimester">
                    {{ $t('validation.attributes.second_semester') }}
                </base-form-label>

                <base-form-input
                    id="second_semester"
                    v-model="form.second_semester"
                    :placeholder="
                        $t('auth.placeholders.fill', { attribute: $t('validation.attributes.second_semester') })
                    "
                    step="0.01"
                    type="number"
                    @change="form.validate('second_semester')"
                ></base-form-input>

                <div v-if="form.errors?.second_semester" class="mt-2">
                    <base-input-error :message="form.errors.second_semester"></base-input-error>
                </div>
            </div>
            <!-- End: Second Semester-->

            <!-- Begin: General Average-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="average">
                    {{ $t('general_average') }}
                </base-form-label>

                <base-form-input
                    id="average"
                    v-model="form.average"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('general_average') })"
                    step="0.01"
                    type="number"
                    @change="form.validate('average')"
                ></base-form-input>

                <div v-if="form.errors?.average" class="mt-2">
                    <base-input-error :message="form.errors.average"></base-input-error>
                </div>
            </div>
            <!-- End: General Average-->

            <!-- Begin: Note-->
            <div class="col-span-12">
                <base-form-label for="note">
                    {{ $t('notes') }}
                </base-form-label>

                <base-form-text-area
                    id="note"
                    v-model="form.note"
                    :placeholder="
                        $t('auth.placeholders.fill', {
                            attribute: $t('notes')
                        })
                    "
                    rows="6"
                    @change="form?.validate('note')"
                ></base-form-text-area>

                <base-form-input-error>
                    <div v-if="form?.invalid('note')" class="mt-2 text-danger" data-test="error_note_message">
                        {{ form.errors.note }}
                    </div>
                </base-form-input-error>
            </div>
            <!-- End: Note-->
        </template>
    </create-edit-modal>
</template>
