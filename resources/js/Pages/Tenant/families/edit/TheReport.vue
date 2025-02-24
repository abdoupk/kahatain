<script lang="ts" setup>
import type { FamilyEditPreviewType, FamilyUpdateReportFormType } from '@/types/families'

import { useForm } from 'laravel-precognition-vue'
import { reactive, ref } from 'vue'

import BaseVCalendar from '@/Components/Base/VCalendar/BaseVCalendar.vue'
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import BaseClassicEditor from '@/Components/Base/editor/BaseClassicEditor.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheMemberSelector from '@/Components/Global/TheMemberSelector.vue'

import { formatDate, omit } from '@/utils/helper'

const props = defineProps<{ preview: FamilyEditPreviewType }>()

const inputs = reactive<FamilyUpdateReportFormType>(omit(props.preview, ['family_id', 'id']))

const form = useForm('put', route('tenant.families.report-update', props.preview.family_id), inputs)

const updateSuccess = ref(false)

const submit = () => {
    form.submit({
        onSuccess() {
            updateSuccess.value = true

            Object.keys(form.errors).forEach((error) => {
                form.forgetError(error as keyof FamilyUpdateReportFormType)
            })
        },
        onFinish() {
            updateSuccess.value = false
        }
    })
}
</script>

<template>
    <!-- BEGIN: The Report -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-9">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('the_report') }}</h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-sm font-medium text-slate-400 dark:bg-darkmode-400"
            >
                {{ formatDate(preview.preview_date, 'long') }}
            </div>
        </div>

        <form @submit.prevent="submit">
            <div class="grid grid-cols-12 gap-4 p-5">
                <div class="col-span-12">
                    <base-form-label for="report">
                        {{ $t('the_report') }}
                    </base-form-label>

                    <base-classic-editor
                        id="report"
                        v-model="form.report"
                        @blur="form?.validate('report')"
                    ></base-classic-editor>

                    <base-form-input-error :form field_name="report"> </base-form-input-error>
                </div>

                <div class="col-span-12 sm:col-span-8">
                    <base-form-label for="inspectors_members">
                        {{ $t('inspectors_members') }}
                    </base-form-label>

                    <div>
                        <the-member-selector
                            v-model:member="form.inspectors"
                            :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('inspectors_members') })"
                            multiple
                            @update:members="form?.validate('inspectors')"
                        ></the-member-selector>
                    </div>

                    <base-form-input-error :form field_name="inspectors"> </base-form-input-error>
                </div>

                <div class="col-span-12 sm:col-span-4">
                    <base-form-label for="preview_date">
                        {{ $t('preview_date') }}
                    </base-form-label>

                    <base-v-calendar id="preview_date" v-model:date="form.preview_date"></base-v-calendar>

                    <base-form-input-error :form field_name="preview_date"> </base-form-input-error>
                </div>

                <base-button :disabled="form.processing" class="!mt-0 w-20" type="submit" variant="primary">
                    {{ $t('save') }}

                    <spinner-button-loader :show="form.processing" class="ms-auto"></spinner-button-loader>
                </base-button>
            </div>
        </form>
        <div>
            <!-- BEGIN: The Report -->
            <!-- END: The Report -->

            <!-- BEGIN: Inspectors members -->
            <!-- END: Inspectors members -->

            <!-- BEGIN: Preview Date -->
            <!-- END: Preview date -->
        </div>
    </div>
    <!-- END: The Report -->

    <success-notification :open="updateSuccess" :title="$t('successfully_updated')"></success-notification>
</template>
