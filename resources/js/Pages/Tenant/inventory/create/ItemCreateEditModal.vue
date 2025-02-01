<script lang="ts" setup>
import { useInventoryStore } from '@/stores/inventory'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, ref } from 'vue'

import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInputError.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseFormSelect = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormSelect.vue'))

const BaseFormTextArea = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormTextArea.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const BaseInputGroup = defineAsyncComponent(() => import('@/Components/Base/form/InputGroup/BaseInputGroup.vue'))

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

defineProps<{
    open: boolean
}>()

// Get the items store
const inventoryStore = useInventoryStore()

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = computed(() => {
    return inventoryStore.item.id
        ? $t('successfully_updated')
        : $t('successfully_created', { attribute: $t('the_item') })
})

const form = computed(() => {
    if (inventoryStore.item.id) {
        return useForm('put', route('tenant.items.update', inventoryStore.item.id), { ...inventoryStore.item })
    }

    return useForm('post', route('tenant.items.store'), { ...inventoryStore.item })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    setTimeout(() => {
        router.get(
            route('tenant.inventory.index'),
            {},
            {
                only: ['items'],
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

// Compute the slideover title based on the item id
const modalTitle = computed(() => {
    return inventoryStore.item.id
        ? $t('modal_update_title', { attribute: $t('the_item') })
        : $tc('add new', 1, { attribute: $t('item') })
})

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the item id
const modalType = computed(() => {
    return inventoryStore.item.id ? 'update' : 'create'
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
            <!-- Begin: name-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="name">
                    {{ $t('item_name') }}
                </base-form-label>

                <base-form-input
                    id="name"
                    v-model="form.name"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('item_name') })"
                    type="text"
                    @change="form.validate('name')"
                />

                <div v-if="form.errors?.name" class="mt-2">
                    <base-input-error :message="form.errors.name"></base-input-error>
                </div>
            </div>
            <!-- End: name-->

            <!-- Begin: quantity & Unit-->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="quantity">
                    {{ $t('validation.attributes.qty') }}
                </base-form-label>

                <base-input-group>
                    <base-form-input
                        id="quantity"
                        v-model="form.qty"
                        :placeholder="
                            $t('auth.placeholders.fill', {
                                attribute: $t('validation.attributes.qty')
                            })
                        "
                        maxlength="6"
                        type="text"
                        @change="form?.validate('qty')"
                        @keydown="allowOnlyNumbersOnKeyDown"
                    ></base-form-input>

                    <base-form-select v-model="form.unit" class="!w-28">
                        <option value="kg">{{ $t('kg') }}</option>
                        <option value="liter">{{ $t('liter') }}</option>
                        <option value="piece">{{ $t('piece') }}</option>
                    </base-form-select>
                </base-input-group>

                <div v-if="form.errors?.qty" class="mt-2">
                    <base-input-error :message="form.errors.qty"></base-input-error>
                </div>
            </div>
            <!-- End: quantity & Unit-->

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

                <base-form-input-error :form field_name="note"></base-form-input-error>
            </div>
            <!-- End: Note-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
