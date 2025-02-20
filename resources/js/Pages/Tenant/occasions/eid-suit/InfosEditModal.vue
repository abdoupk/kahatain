<script lang="ts" setup>
import { useEidSuitsStore } from '@/stores/eid-suits'
import { useOrphansStore } from '@/stores/orphans'
import { usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { computed, nextTick, ref, watch } from 'vue'

import ShopAddressField from '@/Pages/Tenant/occasions/eid-suit/ShopAddressField.vue'

import BaseAlert from '@/Components/Base/Alert/BaseAlert.vue'
import TheAlertDismissButton from '@/Components/Base/Alert/TheAlertDismissButton.vue'
import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'
import CreateEditModal from '@/Components/Global/CreateEditModal.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import MembersFilterDropDown from '@/Components/Global/filters/MembersFilterDropDown.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { loadShopOwnerNames, loadShopOwnerPhoneNumbers } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{
    open: boolean
    orphanId: string
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
    user_id: ''
})

const eidSuitsStore = useEidSuitsStore()

const form = computed(() => {
    if (props.orphanId) {
        return useForm('patch', route('tenant.occasions.eid-suit.save-infos', props.orphanId), inputs.value)
    }

    return useForm('patch', route('tenant.occasions.eid-suit.bulk-update'), inputs.value)
})

const handleSubmit = () => {
    loading.value = true

    form.value.setData({
        ...form.value.data(),
        ids: props.orphanId ? undefined : orphansStore.selectedOrphans,
        shoes_shop_name: inputs.value.shoes_shop_name?.missing
            ? inputs.value.shoes_shop_name?.label
            : inputs.value.shoes_shop_name,
        clothes_shop_name: inputs.value.clothes_shop_name?.missing
            ? inputs.value.clothes_shop_name?.label
            : inputs.value.clothes_shop_name,
        shoes_shop_phone_number: inputs.value.shoes_shop_phone_number?.missing
            ? inputs.value.shoes_shop_phone_number?.value
            : inputs.value.shoes_shop_phone_number,
        clothes_shop_phone_number: inputs.value.clothes_shop_phone_number?.missing
            ? inputs.value.clothes_shop_phone_number?.value
            : inputs.value.clothes_shop_phone_number,
        clothes_shop_address: inputs.value.clothes_shop_address?.missing
            ? inputs.value.clothes_shop_address?.value
            : inputs.value.clothes_shop_address,
        shoes_shop_address: inputs.value.shoes_shop_address?.missing
            ? inputs.value.shoes_shop_address?.value
            : inputs.value.shoes_shop_address
    })

    form.value.submit({
        onSuccess() {
            showSuccessNotification.value = true

            setTimeout(() => {
                emit('close')
            }, 300)

            nextTick(() => {
                showSuccessNotification.value = false

                useOrphansStore().orphans = []

                form.value.reset()
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

const notifiable = ref({})

const orphansUpdatedCount = ref(0)

window.Echo.channel('eid-suit-infos-updated').listen('EidSuitInfosUpdatedEvent', (e) => {
    const exists = e.ids.some((item) => orphansStore.selectedOrphans.includes(item))

    if (exists && props.open && usePage().props.auth.user?.id !== e.user?.id) {
        notifiable.value = e.user

        orphansUpdatedCount.value = e.ids.length

        showWarningAlert.value = true

        disabled.value = true

        document.getElementById('create-edit-modal-form')?.scrollIntoView({
            behavior: 'smooth'
        })
    }
})

watch(
    () => props.orphanId,
    async (value) => {
        if (value) {
            const a = await useOrphansStore().getEidSuitInfos(value)

            inputs.value = {
                clothes_shop_name: a.eid_suit.clothes_shop_name,
                clothes_shop_address: a.eid_suit.clothes_shop_address,
                clothes_shop_location: a.eid_suit.clothes_shop_location,
                clothes_shop_phone_number: a.eid_suit.clothes_shop_phone_number,
                shoes_shop_name: a.eid_suit.shoes_shop_name,
                shoes_shop_address: a.eid_suit.shoes_shop_address,
                shoes_shop_location: a.eid_suit.shoes_shop_location,
                shoes_shop_phone_number: a.eid_suit.shoes_shop_phone_number,
                note: a.eid_suit.note,
                user_id: a.eid_suit.user_id
            }
        }
    }
)
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

                        <span
                            v-if="orphansStore.selectedOrphans.length === 1 && orphansUpdatedCount > 1"
                            class="text-slate-800 dark:text-slate-500"
                        >
                            {{
                                $tc(
                                    'bulk_update_orphans_eid_suit_infos_warning_single',
                                    notifiable.gender === 'male' ? 1 : 0,
                                    { user_name: notifiable.name }
                                )
                            }}
                        </span>

                        <span
                            v-else-if="orphansStore.selectedOrphans.length > 1 && orphansUpdatedCount > 1"
                            class="text-slate-800 dark:text-slate-500"
                        >
                            {{
                                $tc(
                                    'bulk_update_orphans_eid_suit_infos_warning_multiple',
                                    notifiable.gender === 'male' ? 1 : 0,
                                    { user_name: notifiable.name }
                                )
                            }}
                        </span>

                        <!--                        <span-->
                        <!--                            v-else-if="orphansStore.selectedOrphans.length === 1"-->
                        <!--                            class="text-slate-800 dark:text-slate-500"-->
                        <!--                        >-->
                        <!--                            {{-->
                        <!--                                $tc('update_orphan_eid_suit_infos', notifiable.gender === 'male' ? 1 : 0, {-->
                        <!--                                    name: notifiable.name-->
                        <!--                                })-->
                        <!--                            }}-->
                        <!--                        </span>-->

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
                    v-model="inputs.user_id"
                    class="!mt-0"
                ></members-filter-drop-down>

                <base-form-input-error :form field_name="user_id"></base-form-input-error>
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
                    :options="eidSuitsStore.shopNames"
                    class="mt-0"
                    create-option
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
                    :options="eidSuitsStore.shopPhoneNumbers"
                    class="mt-0"
                    create-option
                ></base-combobox>

                <base-form-input-error :form field_name="clothes_shop_phone_number"></base-form-input-error>
            </div>
            <!-- End: Clothes Shop phone number  -->

            <!-- Begin: Clothes Shop address  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="clothes_shop_address">
                    {{ $t('clothes_shop_location') }}
                </base-form-label>

                <shop-address-field
                    v-model:address="inputs.clothes_shop_address"
                    v-model:location="inputs.clothes_shop_location"
                    :select_location_label="$t('select_location')"
                >
                </shop-address-field>

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
                    :options="eidSuitsStore.shopNames"
                    class="mt-0"
                    create-option
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
                    :options="eidSuitsStore.shopPhoneNumbers"
                    class="mt-0"
                    create-option
                ></base-combobox>

                <base-form-input-error :form field_name="shoes_shop_phone_number"></base-form-input-error>
            </div>
            <!-- End: Shoes Shop phone number  -->

            <!-- Begin: Shoes Shop address  -->
            <div class="col-span-12 sm:col-span-6">
                <base-form-label htmlFor="shoes_shop_address">
                    {{ $t('shoes_shop_location') }}
                </base-form-label>

                <div class="w-full">
                    <shop-address-field
                        v-model:address="inputs.shoes_shop_address"
                        v-model:location="inputs.shoes_shop_location"
                        :select_location_label="$t('select_location')"
                    >
                    </shop-address-field>
                </div>

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

    <success-notification :open="showSuccessNotification" :title="$t('successfully_updated')"></success-notification>
</template>
