<script lang="ts" setup>
import { useVocationalTrainingAchievementsStore } from '@/stores/vocational-training-achievement'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import TheVocationalTrainingSelector from '@/Components/Global/TheVocationalTrainingSelector.vue'

import { $t, $tc } from '@/utils/i18n'

defineProps<{
    open: boolean
}>()

// Get the vocationalTrainingAchievement store
const vocationalTrainingAchievementStore = useVocationalTrainingAchievementsStore()

// Initialize a ref for loading state
const loading = ref(false)

const form = computed(() => {
    if (vocationalTrainingAchievementStore.vocationalTrainingAchievement.id) {
        return useForm(
            'put',
            route(
                'tenant.vocational-training-achievements.update',
                vocationalTrainingAchievementStore.vocationalTrainingAchievement.id
            ),
            { ...vocationalTrainingAchievementStore.vocationalTrainingAchievement }
        )
    }

    return useForm('post', route('tenant.vocational-training-achievements.store'), {
        ...vocationalTrainingAchievementStore.vocationalTrainingAchievement
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
            route('tenant.vocational-training-achievements.index'),
            {},
            {
                only: ['vocationalTrainingAchievement'],
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
    return vocationalTrainingAchievementStore.vocationalTrainingAchievement.id
        ? $t('modal_update_title', { attribute: $t('the_vocational_training') })
        : $tc('add new', 1, { attribute: $t('the_vocational_training') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the school id
const modalType = computed(() => {
    return vocationalTrainingAchievementStore.vocationalTrainingAchievement.id ? 'update' : 'create'
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
                <base-form-label htmlFor="vocational_training_id">
                    {{ $t('speciality') }}
                </base-form-label>

                <div>
                    <the-vocational-training-selector
                        id="vocational_training_id"
                        v-model:vocational-training="form.vocational_training_id"
                    ></the-vocational-training-selector>
                </div>

                <div v-if="form.errors?.vocational_training_id" class="mt-2">
                    <base-input-error :message="form.errors.vocational_training_id"></base-input-error>
                </div>
            </div>
            <!-- End: Academic Level-->

            <!-- Begin: Institute-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="institute">
                    {{ $t('institute') }}
                </base-form-label>

                <base-form-input
                    id="institute"
                    ref="firstInputRef"
                    v-model="form.institute"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('institute_name') })"
                    type="text"
                    @change="form.validate('institute')"
                />

                <div v-if="form.errors?.institute" class="mt-2">
                    <base-input-error :message="form.errors.institute"></base-input-error>
                </div>
            </div>
            <!-- End: Institute-->

            <!-- Begin: Year-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="year">
                    {{ $t('vocational_training_year') }}
                </base-form-label>

                <base-form-select id="year" v-model="form.year" @change="form.validate('year')">
                    <option v-for="year in years" :key="year" :value="year">
                        {{ year }}
                    </option>
                </base-form-select>

                <div v-if="form.errors?.year" class="mt-2">
                    <base-input-error :message="form.errors.year"></base-input-error>
                </div>
            </div>
            <!-- End: Year-->

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
