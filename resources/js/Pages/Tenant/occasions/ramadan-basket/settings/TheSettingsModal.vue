<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, ref } from 'vue'

import { $t } from '@/utils/i18n'

const TheRamadanBasketCategories = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/ramadan-basket/settings/TheRamadanBasketCategories.vue')
)

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseFormInput = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormInput.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const BaseInputGroup = defineAsyncComponent(() => import('@/Components/Base/form/InputGroup/BaseInputGroup.vue'))

const BaseInputGroupText = defineAsyncComponent(
    () => import('@/Components/Base/form/InputGroup/BaseInputGroupText.vue')
)

const CreateEditModal = defineAsyncComponent(() => import('@/Components/Global/CreateEditModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

defineProps<{
    open: boolean
}>()

// Get the sponsorships store
const sponsorshipsStore = useSponsorshipsStore()

// Initialize a ref for loading state
const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = $t('successfully_updated')

const form = computed(() => {
    return useForm('patch', route('tenant.occasions.ramadan-basket.update-settings'), {
        ...sponsorshipsStore.ramadan_sponsorship
    })
})

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

// Function to handle success and close the slideover after a delay
const handleSuccess = () => {
    sponsorshipsStore.ramadan_sponsorship = form.value.data()

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

// Compute the slideover title based on the zone id
const modalTitle = $t('settings')

// Initialize a ref for the first input element
const firstInputRef = ref<HTMLElement>()

// Compute the slideover type based on the zone id
const modalType = 'update'

const addInterval = () => {
    form.value.categories.push({
        minimum: null,
        maximum: null,
        category: null
    })
}

const removeInterval = (index: number) => {
    if (index === 0) return

    form.value.categories.splice(index, 1)
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
            <!-- Begin: Threshold-->
            <div class="col-span-12 sm:col-span-4">
                <base-form-label htmlFor="threshold">
                    {{ $t('settings.threshold') }}
                </base-form-label>

                <base-input-group>
                    <base-form-input
                        id="threshold"
                        v-model="form.threshold"
                        :placeholder="
                            $t('auth.placeholders.tomselect', {
                                attribute: $t('settings.threshold')
                            })
                        "
                        type="number"
                        @change="form.validate('threshold')"
                    ></base-form-input>

                    <base-input-group-text>
                        {{ $t('DA') }}
                    </base-input-group-text>
                </base-input-group>

                <div v-if="form.errors?.threshold" class="mt-2">
                    <base-input-error :message="form.errors.threshold"></base-input-error>
                </div>
            </div>
            <!-- End: Threshold-->

            <!-- Begin: Categories for calculation of sponsorship rate-->
            <div class="col-span-12 grid gap-4">
                <div class="mt-1.5 text-base">{{ $t('settings.categories_for_categorise_ramadan_baskets') }}</div>

                <the-ramadan-basket-categories
                    v-for="(category, index) in form.categories"
                    :key="index"
                    v-model:category="category.category"
                    v-model:maximum="category.maximum"
                    v-model:minimum="category.minimum"
                    :form
                    :index
                    @remove-interval="removeInterval(index)"
                ></the-ramadan-basket-categories>
            </div>

            <div class="col-span-12 flex items-center justify-center">
                <base-button
                    class="mx-auto mt-3 block w-1/2 border-dashed dark:text-slate-500"
                    type="button"
                    variant="outline-primary"
                    @click.prevent="addInterval"
                >
                    <svg-loader class="inline fill-primary dark:fill-slate-500" name="icon-plus"></svg-loader>

                    {{ $t('add interval') }}
                </base-button>
            </div>
            <!-- End: Categories for calculation of sponsorship rate-->
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
