<script lang="ts" setup>
import { useOrphansStore } from '@/stores/orphans'
import { usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import BaseAlert from '@/Components/Base/Alert/BaseAlert.vue'
import TheAlertDismissButton from '@/Components/Base/Alert/TheAlertDismissButton.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAddressField from '@/Components/Global/TheAddressField/TheAddressField.vue'
import MembersFilterDropDown from '@/Components/Global/filters/MembersFilterDropDown.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { loadShopOwnerNames, loadShopOwnerPhoneNumbers } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    open: boolean
}>()

const emit = defineEmits(['close'])

const loading = ref(false)

const orphansStore = useOrphansStore()

const inputs = ref({
    clothes_shop_name: '',
    clothes_shop_phone_number: '',
    clothes_shop_address: '',
    clothes_shop_location: null,
    shoes_shop_address: '',
    shoes_shop_location: null,
    shoes_shop_name: '',
    shoes_shop_phone_number: '',
    note: '',
    ids: [],
    designated_member: ''
})

const form = useForm('patch', route('tenant.occasions.eid-suit.bulk-update'), inputs.value)

const handleSubmit = () => {
    loading.value = true

    form.setData({
        ...form.data(),
        ids: orphansStore.orphans,
        shoes_shop_name: inputs.value.shoes_shop_name?.name,
        clothes_shop_name: inputs.value.clothes_shop_name?.name,
        shoes_shop_phone_number: inputs.value.shoes_shop_phone_number?.value,
        clothes_shop_phone_number: inputs.value.clothes_shop_phone_number?.value
    })

    form.submit({
        onSuccess() {
            showSuccessNotification.value = true

            setTimeout(() => {
                emit('close')
            }, 300)

            nextTick(() => {
                showSuccessNotification.value = false

                useOrphansStore().orphans = []

                form.reset()
            })
        },

        onFinish() {
            loading.value = false
        }
    })
}

const firstInputRef = ref<HTMLElement>()

const showSuccessNotification = ref(false)

const showWarningAlert = ref(false)

const disabled = ref(false)

const userName = ref('')

window.Echo.channel('eid-suit-infos-updated').listen('EidSuitInfosUpdatedEvent', (e) => {
    const exists = e.ids.some((item) => orphansStore.orphans.includes(item))

    if (exists && props.open && usePage().props.auth.user?.id !== e.user?.id) {
        userName.value = e.user?.name

        showWarningAlert.value = true

        disabled.value = true

        document.getElementById('create-edit-modal-form')?.scrollIntoView({
            behavior: 'smooth'
        })
    }
})
</script>

<template>
    <create-edit-modal
        :disabled
        :focusable-input="firstInputRef"
        :loading
        :open
        :title="$t('bulk_update')"
        modal-type="update"
        size="lg"
        @close="
            () => {
                emit('close')
                showWarningAlert = false
                disabled = false
            }
        "
        @handle-submit="handleSubmit"
    >
        <template #description>
            <div v-if="showWarningAlert" class="col-span-12 w-full">
                <base-alert
                    v-slot="{ dismiss }"
                    class="dark:border-darkmode-400 dark:bg-darkmode-400"
                    dismissible
                    variant="soft-danger"
                >
                    <div class="flex items-center">
                        <span>
                            <svg-loader class="me-3 h-6 w-6" name="icon-triangle-exclamation" />
                        </span>

                        <span class="text-slate-800 dark:text-slate-500">
                            {{ $t('bulk_update_warning', { name: userName }) }}
                        </span>

                        <the-alert-dismiss-button @click="dismiss">
                            <svg-loader class="stroke-red-900 dark:!stroke-white" name="icon-x"></svg-loader>
                        </the-alert-dismiss-button>
                    </div>
                </base-alert>
            </div>

            <!-- Begin: Designated member  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="designated_member">
                    {{ $t('designated_member') }}
                </base-form-label>

                <members-filter-drop-down
                    id="designated_member"
                    v-model="form.designated_member"
                    class="!mt-0"
                ></members-filter-drop-down>

                <base-form-input-error :form field_name="designated_member"></base-form-input-error>
            </div>
            <!-- End: Designated member  -->

            <!-- Begin: Clothes Shop name  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="clothes_shop_name">
                    {{ $t('clothes_shop_name') }}
                </base-form-label>

                <base-combobox
                    id="clothes_shop_name"
                    v-model="inputs.clothes_shop_name"
                    :load-options="loadShopOwnerNames"
                    :options="[]"
                    class="mt-0"
                    create-option
                    label-key="name"
                    value-key="id"
                ></base-combobox>

                <base-form-input-error :form field_name="clothes_shop_name"></base-form-input-error>
            </div>
            <!-- End: Clothes Shop name  -->

            <!-- Begin: Clothes Shop phone number  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="clothes_shop_phone_number">
                    {{ $t('clothes_shop_phone_number') }}
                </base-form-label>

                <base-combobox
                    id="clothes_shop_phone_number"
                    v-model="inputs.clothes_shop_phone_number"
                    :load-options="loadShopOwnerPhoneNumbers"
                    :options="[]"
                    class="mt-0"
                    create-option
                    label-key="label"
                    value-key="value"
                ></base-combobox>

                <base-form-input-error :form field_name="clothes_shop_phone_number"></base-form-input-error>
            </div>
            <!-- End: Clothes Shop phone number  -->

            <!-- Begin: Clothes Shop address  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="clothes_shop_address">
                    {{ $t('clothes_shop_location') }}
                </base-form-label>

                <the-address-field
                    v-model:address="form.clothes_shop_address"
                    v-model:location="form.clothes_shop_location"
                    :select_location_label="$t('select_location')"
                    class="!mt-0"
                ></the-address-field>

                <base-form-input-error :form field_name="clothes_shop_address"></base-form-input-error>
            </div>
            <!-- End: Clothes Shop address  -->

            <!-- Begin: Shoes Shop name  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="shoes_shop_name">
                    {{ $t('shoes_shop_name') }}
                </base-form-label>

                <base-combobox
                    id="shoes_shop_name"
                    v-model="inputs.shoes_shop_name"
                    :load-options="loadShopOwnerNames"
                    :options="[]"
                    class="mt-0"
                    create-option
                    label-key="name"
                    value-key="id"
                ></base-combobox>

                <base-form-input-error :form field_name="shoes_shop_name"></base-form-input-error>
            </div>
            <!-- End: Shoes Shop name  -->

            <!-- Begin: Shoes Shop phone number  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="shoes_shop_phone_number">
                    {{ $t('shoes_shop_phone_number') }}
                </base-form-label>

                <base-combobox
                    id="shoes_shop_phone_number"
                    v-model="inputs.shoes_shop_phone_number"
                    :load-options="loadShopOwnerPhoneNumbers"
                    :options="[]"
                    class="mt-0"
                    create-option
                    label-key="label"
                    value-key="value"
                ></base-combobox>

                <base-form-input-error :form field_name="shoes_shop_phone_number"></base-form-input-error>
            </div>
            <!-- End: Shoes Shop phone number  -->

            <!-- Begin: Shoes Shop address  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="shoes_shop_address">
                    {{ $t('shoes_shop_location') }}
                </base-form-label>

                <the-address-field
                    v-model:address="form.shoes_shop_address"
                    v-model:location="form.shoes_shop_location"
                    :select_location_label="$t('select_location')"
                ></the-address-field>

                <base-form-input-error :form field_name="shoes_shop_address"></base-form-input-error>
            </div>
            <!-- End: Shoes Shop address  -->

            <div class="col-span-12">
                <base-form-label htmlFor="note">
                    {{ $t('notes') }}
                </base-form-label>

                <base-form-text-area
                    id="note"
                    v-model="form.note"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('notes') })"
                    rows="4"
                ></base-form-text-area>

                <base-form-input-error :form field_name="note"></base-form-input-error>
            </div>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="$t('successfully_updated')"></success-notification>
</template>
