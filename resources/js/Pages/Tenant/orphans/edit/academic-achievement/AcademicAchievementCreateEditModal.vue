<script lang="ts" setup>
import type { AcademicLevelType } from '@/types/lessons'

import { useAcademicAchievementsStore } from '@/stores/academic-achievement'
import { useAcademicLevelsStore } from '@/stores/academic-level'
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

// Get the academicAchievement store
const academicAchievementStore = useAcademicAchievementsStore()

// Initialize a ref for loading state
const loading = ref(false)

const form = computed(() => {
    if (academicAchievementStore.academicAchievement.id) {
        return useForm(
            'put',
            route('tenant.academic-achievements.update', academicAchievementStore.academicAchievement.id),
            { ...academicAchievementStore.academicAchievement }
        )
    }

    return useForm('post', route('tenant.academic-achievements.store'), {
        ...academicAchievementStore.academicAchievement
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
        router.get(
            route('tenant.academic-achievements.index'),
            {},
            {
                only: ['academicAchievement'],
                preserveState: true
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
    return academicAchievementStore.academicAchievement.id
        ? $t('modal_update_title', { attribute: $t('the_academic_achievement') })
        : $tc('add new', 1, { attribute: $t('the_academic_achievement') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the school id
const modalType = computed(() => {
    return academicAchievementStore.academicAchievement.id ? 'update' : 'create'
})

const academicLevels = ref<AcademicLevelType[]>([])

const academicLevelsStore = useAcademicLevelsStore()

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForOrphansForSelectCollege()
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

            <!-- Begin: Academic Year-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="academic_year">
                    {{ $t('academic_year') }}
                </base-form-label>

                <base-form-select
                    id="academic_year"
                    v-model="form.academic_year"
                    @change="form.validate('academic_year')"
                >
                    <option v-for="year in years" :key="year" :value="year">
                        {{ year }}
                    </option>
                </base-form-select>

                <div v-if="form.errors?.academic_year" class="mt-2">
                    <base-input-error :message="form.errors.academic_year"></base-input-error>
                </div>
            </div>
            <!-- End: Academic Year-->

            <!-- Begin: First Trimester-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="first_trimester">
                    {{ $t('validation.attributes.first_trimester') }}
                </base-form-label>

                <base-form-input
                    id="first_trimester"
                    v-model="form.first_trimester"
                    :placeholder="
                        $t('auth.placeholders.fill', { attribute: $t('validation.attributes.first_trimester') })
                    "
                    step="0.01"
                    type="number"
                    @change="form.validate('first_trimester')"
                ></base-form-input>

                <div v-if="form.errors?.first_trimester" class="mt-2">
                    <base-input-error :message="form.errors.first_trimester"></base-input-error>
                </div>
            </div>
            <!-- End: First Trimester-->

            <!-- Begin: Second Trimester-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="second_trimester">
                    {{ $t('validation.attributes.second_trimester') }}
                </base-form-label>

                <base-form-input
                    id="second_trimester"
                    v-model="form.second_trimester"
                    :placeholder="
                        $t('auth.placeholders.fill', { attribute: $t('validation.attributes.second_trimester') })
                    "
                    step="0.01"
                    type="number"
                    @change="form.validate('second_trimester')"
                ></base-form-input>

                <div v-if="form.errors?.second_trimester" class="mt-2">
                    <base-input-error :message="form.errors.second_trimester"></base-input-error>
                </div>
            </div>
            <!-- End: Second Trimester-->

            <!-- Begin: Third Trimester-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="third_trimester">
                    {{ $t('validation.attributes.third_trimester') }}
                </base-form-label>

                <base-form-input
                    id="third_trimester"
                    v-model="form.third_trimester"
                    :placeholder="
                        $t('auth.placeholders.fill', { attribute: $t('validation.attributes.third_trimester') })
                    "
                    step="0.01"
                    type="number"
                    @change="form.validate('third_trimester')"
                ></base-form-input>

                <div v-if="form.errors?.third_trimester" class="mt-2">
                    <base-input-error :message="form.errors.third_trimester"></base-input-error>
                </div>
            </div>
            <!-- End: Third Trimester-->

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

                <base-form-input-error :form="form" field_name="note"> </base-form-input-error>
            </div>
            <!-- End: Note-->
        </template>
    </create-edit-modal>
</template>
