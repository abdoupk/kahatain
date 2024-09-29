<script lang="ts" setup>
import { useNeedsStore } from '@/stores/needs'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import TheNeedable from '@/Pages/Tenant/needs/TheNeedable.vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { needStatuses } from '@/utils/constants'
import { omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    open: boolean
    closeOnly?: boolean
    showTheNeedable?: boolean
}>()

// Get the needs store
const needsStore = useNeedsStore()

const needStatusesLabels = ({ label }: { label: string }) => {
    return $t(label)
}

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return needsStore.need.id ? $t('successfully_updated') : $t('successfully_created', { attribute: $t('the_need') })
})

const form = computed(() => {
    if (needsStore.need.id) {
        return useForm('put', route('tenant.needs.update', needsStore.need.id), omit({ ...needsStore.need }, ['id']))
    }

    return useForm('post', route('tenant.needs.store'), omit({ ...needsStore.need }, ['id']))
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    if (!props.closeOnly) {
        setTimeout(() => {
            router.get(
                route('tenant.needs.index'),
                {},
                {
                    only: ['needs'],
                    preserveState: true
                }
            )
        }, 200)
    }

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

// Compute the slideover title based on the need id
const modalTitle = computed(() => {
    return needsStore.need.id ? $t('modal_update_title', { attribute: $t('the_demand') }) : $t('new need')
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the need id
const modalType = computed(() => {
    return needsStore.need.id ? 'update' : 'create'
})
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :modal-type="modalType"
        :open
        :title="modalTitle"
        size="lg"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <!-- Begin: Subject  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="subject">
                    {{ $t('validation.attributes.subject') }}
                </base-form-label>

                <base-form-input
                    id="subject"
                    ref="firstInputRef"
                    v-model="form.subject"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.subject') })"
                    type="text"
                    @change="form.validate('subject')"
                />

                <div v-if="form.errors?.subject" class="mt-2">
                    <base-input-error :message="form.errors.subject"></base-input-error>
                </div>
            </div>
            <!-- End: Subject  -->

            <!-- Begin: Status  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="status">
                    {{ $t('validation.attributes.status') }}
                </base-form-label>

                <div>
                    <!-- @vue-ignore -->
                    <base-vue-select
                        v-model:value="form.formatted_status"
                        :custom-label="needStatusesLabels"
                        :options="needStatuses"
                        :placeholder="
                            $t('auth.placeholders.tomselect', { attribute: $t('validation.attributes.the_status') })
                        "
                        label="label"
                        track_by="value"
                        @update:value="
                            (status) => {
                                form.status = status.value

                                form?.validate('status')
                            }
                        "
                    ></base-vue-select>
                </div>

                <div v-if="form.errors?.status" class="mt-2">
                    <base-input-error :message="form.errors.status"></base-input-error>
                </div>
            </div>
            <!-- End: Status  -->

            <div class="col-span-12">
                <the-needable
                    v-if="!needsStore.need.id && showTheNeedable"
                    v-model:needable-type="form.needable_type"
                    :error-message="form.errors.needable_id"
                    @update:needable="
                        (value) => {
                            form.needable_id = value.id
                        }
                    "
                ></the-needable>
            </div>

            <!-- Begin: Demand-->
            <div class="col-span-12">
                <base-form-label htmlFor="demand">
                    {{ $t('the_demand') }}
                </base-form-label>

                <base-form-text-area
                    id="demand"
                    v-model="form.demand"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.demand') })"
                    rows="4"
                    @change="form.validate('demand')"
                />

                <div v-if="form.errors?.demand" class="mt-2">
                    <base-input-error :message="form.errors.demand"></base-input-error>
                </div>
            </div>
            <!-- End: Demand-->

            <!-- Begin: Note-->
            <div class="col-span-12">
                <base-form-label htmlFor="note">
                    {{ $t('validation.attributes.note') }}
                </base-form-label>

                <base-form-text-area
                    id="note"
                    v-model="form.note"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('validation.attributes.note') })"
                    rows="4"
                    @change="form.validate('note')"
                />

                <div v-if="form.errors?.note" class="mt-2">
                    <base-input-error :message="form.errors.note"></base-input-error>
                </div>
            </div>
            <!-- End: Note-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
