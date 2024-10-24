<script lang="ts" setup>
/* eslint-disable */
import type { SubjectType } from '@/types/lessons'
import type { CreateSchoolForm } from '@/types/types'

import { useAcademicLevelsStore } from '@/stores/academic-level'
import { useSubjectsStore } from '@/stores/subjects'
import type { Form } from 'laravel-precognition-vue/dist/types'
import { onMounted, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import TheAcademicLevelSelector from '@/Components/Global/TheAcademicLevelSelector.vue'
import TheSubjectSelector from '@/Components/Global/TheSubjectSelector.vue'
import SvgLoader from '@/Components/SvgLoader.vue'
import { $t } from '@/utils/i18n'

defineProps<{
    form: Form<CreateSchoolForm>
    index: number
}>()

const emit = defineEmits(['removeLesson'])

const academicLevel = defineModel('academicLevel')

const quota = defineModel('quota')

const academicLevels = ref([])

const academicLevelsStore = useAcademicLevelsStore()

const subjects = ref<SubjectType[]>([])

onMounted(async () => {
    academicLevels.value = await academicLevelsStore.getAcademicLevelsForSelectLessons()

    await useSubjectsStore().getSubjects()

    subjects.value = useSubjectsStore().subjects
})
</script>

<template>
    <div class="col-span-12 grid grid-cols-13 gap-4">
        <!-- Begin: Academic Level-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="academic_level">
                {{ $t('academic_level') }}
            </base-form-label>

            <div>
                <the-academic-level-selector
                    v-model:academic-level="academicLevel"
                    :academicLevels
                ></the-academic-level-selector>
            </div>

            <!-- @vue-ignore -->
            <div v-if="form.invalid(`lessons.${index}.academic_level_id`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`lessons.${index}.academic_level_id`]"></base-input-error>
            </div>
        </div>
        <!-- End: Academic Level-->

        <!-- Begin: Subject-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="subject">
                {{ $t('the_subject') }}
            </base-form-label>

            <div>
                <!-- @vue-ignore -->
                <the-subject-selector
                    v-model:subject="form.lessons[index].subject_id"
                    :subjects
                    @update:subject="form?.validate(`lessons.${index}.subject_id`)"
                >
                    :subjects>
                </the-subject-selector>
            </div>
            <!-- @vue-ignore -->
            <div v-if="form.invalid(`lessons.${index}.subject_id`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`lessons.${index}.subject_id`]"></base-input-error>
            </div>
        </div>
        <!-- End: Subject-->

        <!-- Begin: Quota-->
        <div class="col-span-12 sm:col-span-4">
            <base-form-label htmlFor="quota">
                {{ $t('validation.attributes.quota') }}
            </base-form-label>

            <!-- @vue-ignore -->
            <base-form-input
                id="quota"
                v-model="quota"
                :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.quota') })"
                type="number"
                @change="form.validate(`lessons.${index}.quota`)"
            />
            <!-- @vue-ignore -->
            <div v-if="form.invalid(`lessons.${index}.quota`)" class="mt-2">
                <!-- @vue-ignore -->
                <base-input-error :message="form.errors[`lessons.${index}.quota`]"></base-input-error>
            </div>
        </div>
        <!-- End: Quota-->

        <div class="col-span-1 -ms-6 mt-6 flex items-center justify-center">
            <svg-loader
                class="h-5 w-5 cursor-pointer fill-danger"
                name="icon-trash-can"
                @click.prevent="emit('removeLesson', index)"
            ></svg-loader>
        </div>
    </div>
</template>
