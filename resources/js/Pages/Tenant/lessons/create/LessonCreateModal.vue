<script lang="ts" setup>
import type { SubjectType } from '@/types/lessons'
import type { CreateLessonForm } from '@/types/types'

import { useLessonsStore } from '@/stores/lessons'
import { useSchoolsStore } from '@/stores/schools'
import { router } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, ref } from 'vue'

import { omit, setDateToCurrentTime, setTimeFromDate } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const BaseFormSwitch = defineAsyncComponent(() => import('@/Components/Base/form/form-switch/BaseFormSwitch.vue'))

const BaseFormSwitchInput = defineAsyncComponent(
    () => import('@/Components/Base/form/form-switch/BaseFormSwitchInput.vue')
)

const BaseFormSwitchLabel = defineAsyncComponent(
    () => import('@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue')
)

const ColorSelector = defineAsyncComponent(() => import('@/Pages/Tenant/lessons/create/ColorSelector.vue'))

const DateSelector = defineAsyncComponent(() => import('@/Pages/Tenant/lessons/create/DateSelector.vue'))

const OrphansSelector = defineAsyncComponent(() => import('@/Pages/Tenant/lessons/create/OrphansSelector.vue'))

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const TheSchoolSelector = defineAsyncComponent(() => import('@/Components/Global/TheSchoolSelector.vue'))

const TheSubjectSelector = defineAsyncComponent(() => import('@/Components/Global/TheSubjectSelector.vue'))

const props = defineProps<{
    open: boolean
    date: string | Date
}>()

// Get the lessons store
const lessonsStore = useLessonsStore()

// Initialize a ref for loading state
const loading = ref(false)

const subjects = ref<SubjectType[]>([])

const form = computed(() => {
    if (lessonsStore.lesson.id) {
        return useForm(
            'put',
            route('tenant.lessons.update', lessonsStore.lesson.id),
            // eslint-disable-next-line array-element-newline
            omit(lessonsStore.lesson, ['subject', 'lesson', 'formated_date', 'school'])
        )
    }

    return useForm<CreateLessonForm>(
        'post',
        route('tenant.lessons.store'),
        omit(lessonsStore.lesson, ['id', 'update_this_and_all_coming'])
    )
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.lessons.index'),
            {},
            {
                only: ['events'],
                preserveState: false
            }
        )
    }, 200)

    emit('close')
}

// Function to handle form submission
const handleSubmit = async () => {
    loading.value = true

    try {
        form.value.end_date = dayjs(form.value.end_date).add(1, 'hour').toDate()

        form.value.start_date = dayjs(form.value.start_date).add(1, 'hour').toDate()

        await form.value.submit().then(handleSuccess)
    } finally {
        loading.value = false
    }
}

// Compute the slideover title based on the lesson id
const modalTitle = computed(() => {
    return lessonsStore.lesson.id
        ? $t('modal_update_title', { attribute: $t('the_lesson') })
        : $tc('add new', 1, { attribute: $t('lesson') })
})

const date = computed(() => {
    return lessonsStore.lesson.id ? form.value.start_date : props.date
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the lesson id
const modalType = computed(() => {
    return lessonsStore.lesson.id ? 'update' : 'create'
})

const handleCloseModal = () => {
    emit('close')

    form.value.reset()
    // TODO: Find a way to reset the vue select schools
}

const handleUpdateSchool = (schoolId: string) => {
    const schoolSubjects = useSchoolsStore().findSchoolById(schoolId)?.subjects

    if (schoolSubjects) subjects.value = schoolSubjects

    form.value.validate('school_id')
}

const handleUpdateSubject = (subjectId: number) => {
    const schoolInfo = useSchoolsStore().getQuotaAndAcademicLevel(form.value.school_id, subjectId)

    quota.value = schoolInfo?.quota

    form.value.academic_level_id = schoolInfo?.academic_level_id

    form.value.start_date = schoolInfo?.start_date
        ? setTimeFromDate(props.date, schoolInfo?.start_date)
        : setDateToCurrentTime(props.date).toDate()

    form.value.end_date = schoolInfo?.end_date
        ? setTimeFromDate(props.date, schoolInfo?.end_date)
        : setDateToCurrentTime(props.date).toDate()

    form.value.validate('subject_id')
}

const quota = ref<number>()
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :modal-type="modalType"
        :open
        :title="modalTitle"
        size="xl"
        @close="handleCloseModal"
        @handle-submit="handleSubmit"
    >
        <template #body>
            <div class="grid grid-cols-12 gap-4 gap-y-3">
                <!-- Begin: Title-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="title">
                        {{ $t('validation.attributes.title') }}
                    </base-form-label>

                    <base-form-input
                        id="title"
                        ref="firstInputRef"
                        v-model="form.title"
                        :disabled="!lessonsStore.lesson.update_this_and_all_coming"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.title') })"
                        type="text"
                        @change="form.validate('title')"
                    />

                    <div v-if="form.errors?.title" class="mt-2">
                        <base-input-error :message="form.errors.title"></base-input-error>
                    </div>
                </div>
                <!-- End: Title-->

                <!-- Begin: School-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="school">
                        {{ $t('the_school') }}
                    </base-form-label>

                    <div>
                        <the-school-selector
                            id="school"
                            v-model:school="form.school_id"
                            :disabled="!lessonsStore.lesson.update_this_and_all_coming"
                            @update:school="handleUpdateSchool"
                        ></the-school-selector>
                    </div>

                    <div v-if="form.errors?.school_id" class="mt-2">
                        <base-input-error :message="form.errors.school_id"></base-input-error>
                    </div>
                </div>
                <!-- End: School-->

                <!-- Begin: Subject-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="subject">
                        {{ $t('the_subject') }}
                    </base-form-label>

                    <div>
                        <the-subject-selector
                            id="subject"
                            v-model:subject="form.subject_id"
                            :disabled="!lessonsStore.lesson.update_this_and_all_coming"
                            :subjects="subjects"
                            @update:subject="handleUpdateSubject"
                        ></the-subject-selector>
                    </div>

                    <div v-if="form.errors.subject_id" class="mt-2">
                        <base-input-error :message="form.errors.subject_id"></base-input-error>
                    </div>
                </div>
                <!-- End: Subject-->

                <!-- Begin: Orphans-->
                <div class="col-span-12 sm:col-span-6">
                    <base-form-label htmlFor="orphans">
                        {{ $t('the_orphans') }}
                    </base-form-label>

                    <div>
                        <!-- @vue-ignore -->
                        <orphans-selector
                            :academic_level_id="form.academic_level_id"
                            :disabled="!lessonsStore.lesson.update_this_and_all_coming"
                            :orphans="form.orphans"
                            :quota="quota"
                            @update:selected-orphans="
                                (value) => {
                                    form.orphans = value.map((orphan) => orphan.id)
                                }
                            "
                        ></orphans-selector>
                    </div>

                    <div v-if="form.errors?.orphans" class="mt-2">
                        <base-input-error :message="form.errors.orphans"></base-input-error>
                    </div>
                </div>
                <!-- End: Orphans-->

                <!-- Begin: Date Options-->
                <date-selector
                    v-model:disabled="lessonsStore.lesson.update_this_and_all_coming"
                    v-model:end-date="form.end_date"
                    v-model:frequency="form.frequency"
                    v-model:interval="form.interval"
                    v-model:start-date="form.start_date"
                    v-model:until="form.until"
                    :date
                    :form
                    @update:frequency="form.validate('frequency')"
                    @update:interval="form.validate('interval')"
                ></date-selector>
                <!-- End: Date Options-->

                <!-- Begin: Color-->
                <div class="col-span-12 mt-0">
                    <base-form-label htmlFor="color">
                        {{ $t('validation.attributes.color') }}
                    </base-form-label>

                    <color-selector
                        :disabled="!lessonsStore.lesson.update_this_and_all_coming"
                        :model-value="form.color"
                        class="col-span-12"
                        @update:model-value="
                            (value) => {
                                form.color = value

                                form.validate('color')
                            }
                        "
                    ></color-selector>

                    <div v-if="form.errors?.color" class="mt-2">
                        <base-input-error :message="form.errors.color"></base-input-error>
                    </div>
                </div>
                <!-- End: Color-->

                <div v-if="lessonsStore.lesson.id" class="col-span-12 mt-2">
                    <base-form-switch class="text-sm">
                        <base-form-switch-input
                            id="selectThisAndAllComingLessons"
                            v-model="lessonsStore.lesson.update_this_and_all_coming"
                            type="checkbox"
                        ></base-form-switch-input>

                        <base-form-switch-label htmlFor="selectThisAndAllComingLessons">
                            {{ $t('lessons.update_this_and_all_coming') }}
                        </base-form-switch-label>
                    </base-form-switch>
                </div>
            </div>
        </template>
    </create-edit-modal>
</template>
