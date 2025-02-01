<script lang="ts" setup>
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { useForm } from 'laravel-precognition-vue'
import { computed, defineAsyncComponent, onUnmounted, ref } from 'vue'

import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import BaseTab from '@/Components/Base/headless/Tab/BaseTab.vue'
import BaseTabButton from '@/Components/Base/headless/Tab/BaseTabButton.vue'
import BaseTabGroup from '@/Components/Base/headless/Tab/BaseTabGroup.vue'
import BaseTabList from '@/Components/Base/headless/Tab/BaseTabList.vue'
import BaseTabPanel from '@/Components/Base/headless/Tab/BaseTabPanel.vue'
import BaseTabPanels from '@/Components/Base/headless/Tab/BaseTabPanels.vue'
import PaginationDataTable from '@/Components/Global/PaginationDataTable.vue'

import { allowOnlyNumbersOnKeyDown } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const TheSponsorshipRateCategories = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/monthly-sponsorship/settings/TheSponsorshipRateCategories.vue')
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

const sponsorshipsStore = useSponsorshipsStore()

const loading = ref(false)

const showSuccessNotification = ref(false)

const notificationTitle = $t('successfully_updated')

const tabIndex = ref(0)

const form = computed(() => {
    if (tabIndex.value === 0) {
        return useForm('patch', route('tenant.occasions.monthly-sponsorship.update-settings'), {
            ...sponsorshipsStore.monthly_sponsorship
        })
    }

    return useForm('patch', route('tenant.occasions.monthly-sponsorship.update-monthly-basket'), {
        items: sponsorshipsStore.monthly_basket.data
    })
})

const emit = defineEmits(['close'])

const handleSuccess = () => {
    // SponsorshipsStore.monthly_sponsorship = form.value.data()

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

const modalTitle = $t('settings')

const firstInputRef = ref<HTMLElement>()

const modalType = 'update'

const addInterval = () => {
    form.value.categories.push({
        minimum: null,
        maximum: null,
        value: null
    })
}

const removeInterval = (index: number) => {
    if (index === 0) return

    form.value.categories.splice(index, 1)
}

const handleTabChange = (index) => {
    tabIndex.value = index
}

onUnmounted(() => sponsorshipsStore.$reset())
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
        <template #body>
            <base-tab-group @change="handleTabChange">
                <base-tab-list class="flex" variant="link-tabs">
                    <base-tab>
                        <base-tab-button as="button" class="w-full" type="button"> Example Tab 1</base-tab-button>
                    </base-tab>
                    <base-tab>
                        <base-tab-button as="button" class="w-full py-2" type="button"> Example Tab 2</base-tab-button>
                    </base-tab>
                </base-tab-list>

                <base-tab-panels class="mt-5">
                    <base-tab-panel class="grid grid-cols-12 gap-4 gap-y-3">
                        <!-- Begin: University scholarship bachelor-->
                        <div class="col-span-12 sm:col-span-4">
                            <base-form-label htmlFor="university_scholarship_bachelor">
                                {{ $t('validation.attributes.university_scholarship_bachelor') }}
                            </base-form-label>

                            <base-input-group>
                                <base-form-input
                                    id="university_scholarship_bachelor"
                                    ref="firstInputRef"
                                    v-model="form.university_scholarship_bachelor"
                                    :placeholder="
                                        $t('auth.placeholders.tomselect', {
                                            attribute: $t('validation.attributes.university_scholarship_bachelor')
                                        })
                                    "
                                    type="number"
                                    @change="form.validate('university_scholarship_bachelor')"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>

                            <div v-if="form.errors?.university_scholarship_bachelor" class="mt-2">
                                <base-input-error
                                    :message="form.errors.university_scholarship_bachelor"
                                ></base-input-error>
                            </div>
                        </div>
                        <!-- End: University scholarship bachelor-->

                        <!-- Begin: University scholarship Master 1-->
                        <div class="col-span-12 sm:col-span-4">
                            <base-form-label htmlFor="university_scholarship_master_one">
                                {{ $t('validation.attributes.university_scholarship_master_one') }}
                            </base-form-label>

                            <base-input-group>
                                <base-form-input
                                    id="university_scholarship_master_one"
                                    v-model="form.university_scholarship_master_one"
                                    :placeholder="
                                        $t('auth.placeholders.tomselect', {
                                            attribute: $t('validation.attributes.university_scholarship_master_one')
                                        })
                                    "
                                    type="number"
                                    @change="form.validate('university_scholarship_master_one')"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>

                            <div v-if="form.errors?.university_scholarship_master_one" class="mt-2">
                                <base-input-error
                                    :message="form.errors.university_scholarship_master_one"
                                ></base-input-error>
                            </div>
                        </div>
                        <!-- End: University scholarship Master 1-->

                        <!-- Begin: University scholarship Master 2-->
                        <div class="col-span-12 sm:col-span-4">
                            <base-form-label htmlFor="university_scholarship_master_two">
                                {{ $t('validation.attributes.university_scholarship_master_two') }}
                            </base-form-label>

                            <base-input-group>
                                <base-form-input
                                    id="university_scholarship_master_two"
                                    v-model="form.university_scholarship_master_two"
                                    :placeholder="
                                        $t('auth.placeholders.tomselect', {
                                            attribute: $t('validation.attributes.university_scholarship_master_two')
                                        })
                                    "
                                    type="number"
                                    @change="form.validate('university_scholarship_master_two')"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>

                            <div v-if="form.errors?.university_scholarship_master_two" class="mt-2">
                                <base-input-error
                                    :message="form.errors.university_scholarship_master_two"
                                ></base-input-error>
                            </div>
                        </div>
                        <!-- End: University scholarship Master 2-->

                        <!-- Begin: University scholarship Doctorate-->
                        <div class="col-span-12 sm:col-span-4">
                            <base-form-label htmlFor="university_scholarship_doctorate">
                                {{ $t('validation.attributes.university_scholarship_doctorate') }}
                            </base-form-label>

                            <base-input-group>
                                <base-form-input
                                    id="university_scholarship_doctorate"
                                    v-model="form.university_scholarship_doctorate"
                                    :placeholder="
                                        $t('auth.placeholders.tomselect', {
                                            attribute: $t('validation.attributes.university_scholarship_doctorate')
                                        })
                                    "
                                    type="number"
                                    @change="form.validate('university_scholarship_doctorate')"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>

                            <div v-if="form.errors?.university_scholarship_doctorate" class="mt-2">
                                <base-input-error
                                    :message="form.errors.university_scholarship_doctorate"
                                ></base-input-error>
                            </div>
                        </div>
                        <!-- End: University scholarship Doctorate-->

                        <!-- Begin: Unemployment benefit-->
                        <div class="col-span-12 sm:col-span-4">
                            <base-form-label htmlFor="unemployment_benefit">
                                {{ $t('settings.unemployment_benefit') }}
                            </base-form-label>

                            <base-input-group>
                                <base-form-input
                                    id="unemployment_benefit"
                                    v-model="form.unemployment_benefit"
                                    :placeholder="
                                        $t('auth.placeholders.tomselect', {
                                            attribute: $t('settings.unemployment_benefit')
                                        })
                                    "
                                    type="number"
                                    @change="form.validate('unemployment_benefit')"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>

                            <div v-if="form.errors?.unemployment_benefit" class="mt-2">
                                <base-input-error :message="form.errors.unemployment_benefit"></base-input-error>
                            </div>
                        </div>
                        <!-- End: Unemployment benefit-->

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

                        <!-- Begin: Association basket value-->
                        <div class="col-span-12 sm:col-span-4">
                            <base-form-label htmlFor="association_basket_value">
                                {{ $t('validation.attributes.association_basket_value') }}
                            </base-form-label>

                            <base-input-group>
                                <base-form-input
                                    id="association_basket_value"
                                    v-model="form.association_basket_value"
                                    :placeholder="
                                        $t('auth.placeholders.tomselect', {
                                            attribute: $t('validation.attributes.association_basket_value')
                                        })
                                    "
                                    type="number"
                                    @change="form.validate('association_basket_value')"
                                ></base-form-input>

                                <base-input-group-text>
                                    {{ $t('DA') }}
                                </base-input-group-text>
                            </base-input-group>

                            <div v-if="form.errors?.association_basket_value" class="mt-2">
                                <base-input-error :message="form.errors.association_basket_value"></base-input-error>
                            </div>
                        </div>
                        <!-- End: Association basket value-->

                        <!-- Begin: Categories for calculation of sponsorship rate-->
                        <div class="col-span-12 grid gap-4">
                            <div class="mt-1.5 text-base">
                                {{ $t('settings.categories_for_calculation_of_sponsorship_rate') }}
                            </div>

                            <the-sponsorship-rate-categories
                                v-for="(category, index) in form.categories"
                                :key="index"
                                v-model:maximum="category.maximum"
                                v-model:minimum="category.minimum"
                                v-model:value="category.value"
                                :form
                                :index
                                @remove-interval="removeInterval(index)"
                            ></the-sponsorship-rate-categories>
                        </div>

                        <div class="col-span-12 flex items-center justify-center">
                            <base-button
                                class="mx-auto mt-3 block w-1/2 border-dashed dark:text-slate-500"
                                type="button"
                                variant="outline-primary"
                                @click.prevent="addInterval"
                            >
                                <svg-loader
                                    class="inline fill-primary dark:fill-slate-500"
                                    name="icon-plus"
                                ></svg-loader>

                                {{ $t('add_category') }}
                            </base-button>
                        </div>
                        <!-- End: Categories for calculation of sponsorship rate-->
                    </base-tab-panel>

                    <base-tab-panel>
                        <div
                            v-for="(item, index) in sponsorshipsStore.monthly_basket.data"
                            :key="item.id"
                            class="intro-y col-span-12 mt-4 grid grid-cols-12 gap-4"
                        >
                            <div class="col-span-12 sm:col-span-4">
                                <base-form-label :for="`name-${index}`">
                                    {{ $t('item_name') }}
                                </base-form-label>

                                <base-form-input
                                    :id="`name-${index}`"
                                    v-model="item.name"
                                    :placeholder="
                                        $t('auth.placeholders.tomselect', {
                                            attribute: $t('item_name')
                                        })
                                    "
                                    type="text"
                                ></base-form-input>
                            </div>

                            <div class="col-span-12 sm:col-span-4">
                                <base-form-label :for="`qty-${index}`">
                                    {{ $t('validation.attributes.qty_for_family') }}
                                </base-form-label>

                                <base-input-group>
                                    <base-form-input
                                        :id="`qty-${index}`"
                                        v-model="item.qty_for_family"
                                        :placeholder="
                                            $t('auth.placeholders.fill', {
                                                attribute: $t('validation.attributes.qty')
                                            })
                                        "
                                        maxlength="6"
                                        type="text"
                                        @keydown="allowOnlyNumbersOnKeyDown"
                                    ></base-form-input>

                                    <base-form-select v-model="item.unit" class="!w-28">
                                        <option value="kg">{{ $t('kg') }}</option>
                                        <option value="liter">{{ $t('liter') }}</option>
                                        <option value="piece">{{ $t('piece') }}</option>
                                    </base-form-select>
                                </base-input-group>
                            </div>

                            <div class="col-span-12 sm:col-span-4 lg:mt-6 lg:flex lg:items-center lg:justify-center">
                                <base-form-switch class="text-lg">
                                    <base-form-switch-input
                                        :id="`status-${index}`"
                                        v-model="item.status"
                                        type="checkbox"
                                    ></base-form-switch-input>

                                    <base-form-switch-label :htmlFor="`status-${index}`">
                                        {{ $t('validation.attributes.the_status') }}
                                    </base-form-switch-label>
                                </base-form-switch>
                            </div>
                        </div>
                        <pagination-data-table
                            :page="sponsorshipsStore.monthly_basket.meta.current_page"
                            :pages="sponsorshipsStore.monthly_basket.meta.last_page"
                            :per-page="sponsorshipsStore.monthly_basket.meta.per_page"
                            class="mt-4"
                            hide-per-page
                            @change-page="sponsorshipsStore.getMonthlyBasketItems($event)"
                        ></pagination-data-table>
                    </base-tab-panel>
                </base-tab-panels>
            </base-tab-group>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="notificationTitle"></success-notification>
</template>
