<script lang="ts" setup>
import { useTranscriptsStore } from '@/stores/transcripts'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
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

    return useForm('post', route('tenant.transcripts.store'), { ...transcriptsStore.transcript })
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
                only: ['transcripts'],
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
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :modal-type="modalType"
        :open
        :title="modalTitle"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-12 sm:col-span-6" v-for="(subject, index) in transcriptsStore.transcript.subjects">
                <base-form-label htmlFor="name">
                    {{ subject.name }}
                </base-form-label>

                <base-form-input
                    id="name"
                    ref="firstInputRef"
                    v-model="transcriptsStore.transcript.subjects[index].grade"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.name') })"
                    type="number"
                    @change="form.validate()"
                />

                <!--                <div v-if="form.errors?.name" class="mt-2">-->
                <!--                    <base-input-error :message="form.errors.name"></base-input-error>-->
                <!--                </div>-->
            </div>
            <!-- End: Name-->

            <div class="col-span-12">
                {{ transcriptsStore.transcript.subjects }}
            </div>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
