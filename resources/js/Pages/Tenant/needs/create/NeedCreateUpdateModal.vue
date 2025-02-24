<script lang="ts" setup>
import { useNeedsStore } from '@/stores/needs'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, ref } from 'vue'

import TheNeedable from '@/Pages/Tenant/needs/TheNeedable.vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'
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

const needsStore = useNeedsStore()

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

const emit = defineEmits(['close'])

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

const modalTitle = computed(() => {
    return needsStore.need.id ? $t('modal_update_title', { attribute: $t('the_demand') }) : $t('new need')
})

const firstInputRef = ref<HTMLElement>()

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

                <base-form-input-error :form field_name="subject"></base-form-input-error>
            </div>
            <!-- End: Subject  -->

            <!-- Begin: Status  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="status">
                    {{ $t('validation.attributes.status') }}
                </base-form-label>

                <base-list-box
                    v-model="form.status"
                    :options="needStatuses"
                    :placeholder="
                        $t('auth.placeholders.tomselect', { attribute: $t('validation.attributes.the_status') })
                    "
                />

                <base-form-input-error :form field_name="status"></base-form-input-error>
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

                <base-form-input-error :form field_name="demand"></base-form-input-error>
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

                <base-form-input-error :form field_name="note"></base-form-input-error>
            </div>
            <!-- End: Note-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
