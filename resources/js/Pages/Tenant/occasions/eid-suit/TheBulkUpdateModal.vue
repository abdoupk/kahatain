<script lang="ts" setup>
import { useOrphansStore } from '@/stores/orphans'
import { router } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { nextTick, ref } from 'vue'

import RowCombobox from '@/Pages/Tenant/occasions/eid-suit/RowCombobox.vue'

import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheAddressField from '@/Components/Global/TheAddressField/TheAddressField.vue'
import MembersFilterDropDown from '@/Components/Global/filters/MembersFilterDropDown.vue'

import { loadShopOwnerNames, loadShopOwnerPhoneNumbers } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    open: boolean
}>()

const emit = defineEmits(['close'])

const loading = ref(false)

const inputs = ref({
    clothes_shop_name: '',
    clothes_shop_phone_number: '',
    clothes_shop_address: '',
    clothes_shop_location: null,
    shoes_shop_name: '',
    shoes_shop_phone_number: '',
    shoes_shop_address: '',
    shoes_shop_location: null,
    designated_member: null,
    note: '',
    ids: []
})

const handleSubmit = () => {
    loading.value = true

    form.setData({
        ...inputs.value,
        ids: useOrphansStore().orphans,
        designated_member: inputs.value.designated_member?.id,
        clothes_shop_phone_number: inputs.value.clothes_shop_phone_number.name,
        shoes_shop_phone_number: inputs.value.shoes_shop_phone_number.name,
        clothes_shop_name: inputs.value.clothes_shop_name.name,
        shoes_shop_name: inputs.value.shoes_shop_name.name
    })

    form.submit({
        onSuccess() {
            showSuccessNotification.value = true

            router.get(
                route('tenant.occasions.eid-suit.index'),
                {},
                {
                    preserveScroll: true,
                    preserveState: false,
                    only: ['orphans'],
                    onFinish: () => {
                        showSuccessNotification.value = false

                        nextTick(() => {
                            showSuccessNotification.value = false

                            useOrphansStore().orphans = []

                            setTimeout(() => {
                                emit('close')
                            }, 300)
                        })
                    }
                }
            )
        },

        onFinish() {
            loading.value = false
        }
    })
}

const firstInputRef = ref<HTMLElement>()

const showSuccessNotification = ref(false)

const form = useForm('patch', route('tenant.occasions.eid-suit.bulk-update'), inputs.value)
</script>

<template>
    <create-edit-modal
        :focusable-input="firstInputRef"
        :loading
        :open
        :title="$t('bulk_update')"
        modal-type="update"
        size="lg"
        @close="emit('close')"
        @handle-submit="handleSubmit"
    >
        <template #description>
            <!-- Begin: Designated member  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="designated_member">
                    {{ $t('designated_member') }}
                </base-form-label>

                <members-filter-drop-down
                    id="designated_member"
                    :value="inputs.designated_member"
                    class="!mt-0"
                    @update:value="inputs.designated_member = $event"
                ></members-filter-drop-down>

                <base-form-input-error :form field_name="designated_member"></base-form-input-error>
            </div>
            <!-- End: Designated member  -->

            <!-- Begin: Clothes Shop name  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="clothes_shop_name">
                    {{ $t('clothes_shop_name') }}
                </base-form-label>

                <row-combobox
                    id="clothes_shop_name"
                    :has-error="false"
                    :load-options="loadShopOwnerNames"
                    :model-value="inputs.clothes_shop_name"
                    :options="[]"
                    class="!mt-0"
                    max-length="255"
                    @update:model-value="inputs.clothes_shop_name = $event"
                ></row-combobox>

                <base-form-input-error :form field_name="clothes_shop_name"></base-form-input-error>
            </div>
            <!-- End: Clothes Shop name  -->

            <!-- Begin: Clothes Shop phone number  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="clothes_shop_phone_number">
                    {{ $t('clothes_shop_phone_number') }}
                </base-form-label>

                <row-combobox
                    id="clothes_shop_phone_number"
                    :has-error="false"
                    :load-options="loadShopOwnerPhoneNumbers"
                    :model-value="inputs.clothes_shop_phone_number"
                    :options="[]"
                    class="!mt-0"
                    max-length="10"
                    @update:model-value="inputs.clothes_shop_phone_number = $event"
                ></row-combobox>

                <base-form-input-error :form field_name="clothes_shop_phone_number"></base-form-input-error>
            </div>
            <!-- End: Clothes Shop phone number  -->

            <!-- Begin: Clothes Shop address  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="clothes_shop_address">
                    {{ $t('clothes_shop_location') }}
                </base-form-label>

                <the-address-field
                    v-model:address="inputs.clothes_shop_address"
                    v-model:location="inputs.clothes_shop_location"
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

                <row-combobox
                    id="shoes_shop_name"
                    :has-error="false"
                    :load-options="loadShopOwnerNames"
                    :model-value="inputs.shoes_shop_name"
                    :options="[]"
                    class="!mt-0"
                    max-length="255"
                    @update:model-value="inputs.shoes_shop_name = $event"
                ></row-combobox>

                <base-form-input-error :form field_name="shoes_shop_name"></base-form-input-error>
            </div>
            <!-- End: Shoes Shop name  -->

            <!-- Begin: Shoes Shop phone number  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="shoes_shop_phone_number">
                    {{ $t('shoes_shop_phone_number') }}
                </base-form-label>

                <row-combobox
                    id="shoes_shop_phone_number"
                    :has-error="false"
                    :load-options="loadShopOwnerPhoneNumbers"
                    :model-value="inputs.shoes_shop_phone_number"
                    :options="[]"
                    class="!mt-0"
                    max-length="10"
                    @update:model-value="inputs.shoes_shop_phone_number = $event"
                ></row-combobox>

                <base-form-input-error :form field_name="shoes_shop_phone_number"></base-form-input-error>
            </div>
            <!-- End: Shoes Shop phone number  -->

            <!-- Begin: Shoes Shop address  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="shoes_shop_address">
                    {{ $t('shoes_shop_location') }}
                </base-form-label>

                <the-address-field
                    v-model:address="inputs.shoes_shop_address"
                    v-model:location="inputs.shoes_shop_location"
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
                    v-model="inputs.note"
                    :placeholder="$t('auth.placeholders.fill', { attribute: $t('notes') })"
                    rows="4"
                ></base-form-text-area>

                <base-form-input-error :form field_name="note"></base-form-input-error>
            </div>
        </template>
    </create-edit-modal>

    <success-notification :open="showSuccessNotification" :title="'res'"></success-notification>
</template>
