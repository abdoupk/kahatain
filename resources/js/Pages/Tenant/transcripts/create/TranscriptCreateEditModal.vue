<script lang="ts" setup>
import { useTranscriptsStore } from '@/stores/transcripts'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputGroup from '@/Components/Base/form/InputGroup/BaseInputGroup.vue'
import BaseInputGroupText from '@/Components/Base/form/InputGroup/BaseInputGroupText.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { $t, $tc } from '@/utils/i18n'

defineProps<{
    open: boolean
}>()

// Get the transcripts store
const transcriptsStore = useTranscriptsStore()

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return transcriptsStore.transcript.id
        ? $t('successfully_updated')
        : $t('successfully_created', { attribute: $t('the_transcript') })
})

const form = computed(() => {
    if (transcriptsStore.transcript.id) {
        return useForm('put', route('tenant.transcripts.update', transcriptsStore.transcript.id), {
            ...transcriptsStore.transcript
        })
    }

    return useForm('post', route('tenant.transcripts.store', transcriptsStore.transcript.orphan_id), {
        ...transcriptsStore.transcript
    })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close', 'update-transcripts'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.transcripts.index'),
            {},
            {
                only: ['orphans'],
                preserveState: true
            }
        )
    }, 200)

    emit('update-transcripts')

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

// Compute the slideover title based on the transcript id
const modalTitle = computed(() => {
    return transcriptsStore.transcript.id
        ? $t('modal_update_title', {
              attribute: $t('the_transcript')
          })
        : $tc('add new', 0, { attribute: $t('transcript') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the transcript id
const modalType = computed(() => {
    return transcriptsStore.transcript.id ? 'update' : 'create'
})

const maxGrade = computed(() => {
    return form.value.academic_level?.phase_key === 'elementary_school' ? 10 : 20
})
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        size="lg"
        :modal-type="modalType"
        :open
        :title="modalTitle"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <!-- Begin: Grade-->
            <div :key="subject.id" class="col-span-12 sm:col-span-4" v-for="(subject, index) in form.subjects">
                <base-form-label htmlFor="name">
                    {{ subject.name }}
                </base-form-label>

                <base-input-group>
                    <base-form-input
                        id="name"
                        v-model="form.subjects[index].grade"
                        :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.grade') })"
                        type="number"
                        min="0"
                        :max="maxGrade"
                        @change="form.validate(`subjects.${index}.grade`)"
                    ></base-form-input>

                    <base-input-group-text> /{{ String(maxGrade) }}</base-input-group-text>
                </base-input-group>

                <base-form-input-error :field_name="`subjects.${index}.grade`" :form></base-form-input-error>
            </div>
            <!-- End: Grade-->

            <div class="col-span-12 mt-2 grid grid-cols-12 gap-4">
                <div class="col-span-5">
                    <base-form-label htmlFor="trimester_average">
                        {{ $t('the_trimester_average') }}
                    </base-form-label>

                    <base-input-group>
                        <!-- @vue-ignore -->
                        <base-form-input
                            id="trimester_average"
                            v-model="form.average"
                            :placeholder="$t('auth.placeholders.fill', { attribute: $t('the_trimester_average') })"
                            type="number"
                            min="0"
                            :max="maxGrade"
                            @change="form.validate('average')"
                        ></base-form-input>

                        <base-input-group-text> /{{ String(maxGrade) }}</base-input-group-text>
                    </base-input-group>

                    <base-form-input-error field_name="average" :form></base-form-input-error>
                </div>
            </div>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
