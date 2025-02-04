<script lang="ts" setup>
import type { SubjectType } from '@/types/lessons'

import { useSchoolsStore } from '@/stores/schools'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, ref } from 'vue'

import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { generateUUID } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const TheSubjectAndQuota = defineAsyncComponent(() => import('@/Pages/Tenant/schools/create/TheSubjectAndQuota.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

defineProps<{
    open: boolean
    subjects: SubjectType[]
}>()

// Get the schools store
const schoolsStore = useSchoolsStore()

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return schoolsStore.school.id
        ? $t('successfully_updated')
        : $t('successfully_created', { attribute: $t('the_school') })
})

const form = computed(() => {
    if (schoolsStore.school.id) {
        return useForm('put', route('tenant.schools.update', schoolsStore.school.id), {
            ...schoolsStore.school,
            deleted_lessons: []
        })
    }

    return useForm('post', route('tenant.schools.store'), { ...schoolsStore.school })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.schools.index'),
            {},
            {
                only: ['schools'],
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
        await form.value
            .submit({
                onSuccess() {
                    showSuccessNotification.value = true
                },
                onFinish() {
                    showSuccessNotification.value = false
                }
            })
            .then(handleSuccess)
    } finally {
        loading.value = false
    }
}

// Compute the slideover title based on the school id
const modalTitle = computed(() => {
    return schoolsStore.school.id
        ? $t('modal_update_title', { attribute: $t('the_school') })
        : $tc('add new', 0, { attribute: $t('school') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the school id
const modalType = computed(() => {
    return schoolsStore.school.id ? 'update' : 'create'
})

const addLesson = () => {
    form.value.lessons.push({
        id: generateUUID(),
        academic_level_id: null,
        quota: null,
        subject_id: null,
        start_date: new Date(),
        end_date: new Date()
    })
}

const removeLesson = (index: number) => {
    form.value.deleted_lessons.push(form.value.lessons[index].id)

    form.value.lessons.splice(index, 1)
}
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
            <!-- Begin: Name-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="name">
                    {{ $t('school_name') }}
                </base-form-label>

                <base-form-input
                    id="name"
                    ref="firstInputRef"
                    v-model="form.name"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('school_name') })"
                    type="text"
                    @change="form.validate('name')"
                />

                <div v-if="form.errors?.name" class="mt-2">
                    <base-input-error :message="form.errors.name"></base-input-error>
                </div>
            </div>
            <!-- End: Name-->

            <!-- @vue-ignore -->
            <the-subject-and-quota
                v-for="(lesson, index) in form.lessons"
                :key="lesson.id"
                v-model:academic-level="lesson.academic_level_id"
                v-model:endDate="lesson.end_date"
                v-model:quota="lesson.quota"
                v-model:startDate="lesson.start_date"
                v-model:subject="lesson.subject_id"
                :form
                :index
                :subjects
                @update:academic-level="
                    () => {
                        // @ts-ignore
                        form.validate(`lessons.${index}.academic_level_id`)
                    }
                "
                @remove-lesson="removeLesson(index)"
            ></the-subject-and-quota>

            <div class="col-span-12 flex items-center justify-center">
                <base-button
                    class="mx-auto mt-3 block w-1/2 border-dashed dark:text-slate-300"
                    data-test="add_lesson"
                    type="button"
                    variant="outline-primary"
                    @click.prevent="addLesson"
                >
                    <svg-loader class="inline fill-primary dark:fill-slate-300" name="icon-plus"></svg-loader>

                    {{ $t('add lesson') }}
                </base-button>
            </div>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
