<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { useOrphansStore } from '@/stores/orphans'
import { Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { watch } from 'vue'

import ShopAddressField from '@/Pages/Tenant/occasions/eid-suit/ShopAddressField.vue'

import BaseAlert from '@/Components/Base/Alert/BaseAlert.vue'
import TheAlertDismissButton from '@/Components/Base/Alert/TheAlertDismissButton.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import BaseCombobox from '@/Components/Base/headless/Combobox/BaseCombobox.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import MembersFilterDropDown from '@/Components/Global/filters/MembersFilterDropDown.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatCurrency, hasPermission, loadShopOwnerNames, loadShopOwnerPhoneNumbers } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
    showWarningAlert: boolean
    notifiable: object
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showLocationAddressModal', 'showSuccessNotification', 'selectOrphan', 'deselectOrphan'])

const orphansStore = useOrphansStore()

const checkAll = ($event) => {
    const orphans = props.orphans.data.map((orphan) => orphan.id)

    if ($event.target.checked) {
        if (orphansStore.selectedOrphans.length) {
            orphansStore.selectedOrphans = [...new Set([...orphansStore.selectedOrphans, ...orphans])]
        } else {
            orphansStore.selectedOrphans = orphans
        }
    } else {
        orphansStore.selectedOrphans = orphansStore.selectedOrphans.filter((id) => !orphans.includes(id))
    }
}

watch(
    () => props.showWarningAlert,
    () => {
        if (props.showWarningAlert) {
            if (orphansStore.selectedOrphans.length > 0) {
                document.getElementById(useOrphansStore().selectedOrphans[0])?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start',
                    inline: 'start'
                })
            }

            if (orphansStore.selectedOrphans.length > 1) {
                orphansStore.selectedOrphans.forEach((selectedId) => {
                    const orphan = props.orphans.data.find((orphan) => orphan.id === selectedId)

                    if (orphan) {
                        orphan.eid_suit.user_id = props.notifiable?.id
                    }
                })
            }
        }
    }
)

const handleUpdate = (orphan: EidSuitOrphansResource, property) => {
    let value

    if (orphan.eid_suit[property]?.missing) {
        value = orphan.eid_suit[property].value
    } else value = orphan.eid_suit[property]

    useForm('patch', route('tenant.occasions.eid-suit.save-infos', orphan.orphan.id), {
        [property]: value
    }).submit({
        onSuccess() {
            emit('showSuccessNotification')
        }
    })
}

const selectOrphan = (orphan: EidSuitOrphansResource) => {
    orphan.eid_suit.selected = true

    orphansStore.selectedOrphans.push(orphan.id)
}

const deSelectOrphan = (orphan: EidSuitOrphansResource) => {
    // Orphan.eid_suit.selected = false
    //
    // OrphansStore.selectedOrphans.splice(orphansStore.selectedOrphans.indexOf(orphan.id), 1)
}
</script>

<template>
    <base-form-switch class="intro-y -mb-2 mt-6 text-lg @3xl:hidden">
        <base-form-switch-input
            id="check_all"
            :checked="orphansStore.selectedOrphans.length"
            type="checkbox"
            @change="checkAll"
        ></base-form-switch-input>

        <base-form-switch-label class="whitespace-nowrap text-nowrap" htmlFor="check_all">
            {{ $t('check_all') }}
        </base-form-switch-label>
    </base-form-switch>

    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div
            v-for="orphan in orphans.data"
            :id="orphan.id"
            :key="orphan.id"
            class="intro-y !z-10 col-span-12 @xl:col-span-6"
        >
            <div class="box px-5 pb-5 pt-3">
                <div v-if="showWarningAlert && orphan.eid_suit.selected">
                    <base-alert
                        v-slot="{ dismiss }"
                        class="mb-4 dark:border-darkmode-400 dark:bg-darkmode-400"
                        dismissible
                        variant="soft-danger"
                    >
                        <div class="flex items-center">
                            <span>
                                <svg-loader class="me-3 h-6 w-6" name="icon-triangle-exclamation" />
                            </span>

                            <span class="text-slate-800 dark:text-slate-500">
                                {{
                                    $tc('update_orphan_eid_suit_infos', notifiable?.gender === 'male' ? 1 : 0, {
                                        user_name: notifiable?.name,
                                        orphan_name: orphan.orphan.name
                                    })
                                }}
                            </span>

                            <the-alert-dismiss-button @click="dismiss">
                                <svg-loader class="stroke-red-900 dark:!stroke-white" name="icon-x"></svg-loader>
                            </the-alert-dismiss-button>
                        </div>
                    </base-alert>
                </div>

                <base-form-switch-input
                    @update:model-value="
                        ($event) => {
                            if ($event) {
                                selectOrphan(orphan)
                            } else {
                                deSelectOrphan(orphan)
                            }
                        }
                    "
                    :value="orphan.id"
                    class="mb-2"
                    type="checkbox"
                ></base-form-switch-input>

                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        <Link
                            v-if="hasPermission('view_orphans')"
                            :href="route('tenant.orphans.show', orphan.orphan.id)"
                        >
                            {{ orphan.orphan.name }}
                        </Link>

                        <span v-else>
                            {{ orphan.orphan.name }}
                        </span>
                    </div>

                    <base-tippy
                        :content="$t('income_rate')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ formatCurrency(orphan.family.income_rate) }}
                    </base-tippy>
                </div>

                <div class="mt-4 grid grid-cols-12 gap-4">
                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 rtl:!font-semibold">
                            {{ $t('the_sponsor') }}
                        </div>

                        <div class="col-span-7">
                            <Link
                                v-if="hasPermission('view_sponsors')"
                                :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                            >
                                {{ orphan.sponsor.name }}
                            </Link>

                            <span v-else>
                                {{ orphan.sponsor.name }}
                            </span>
                        </div>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 rtl:!font-semibold">
                            {{ $t('sponsor_phone_number') }}
                        </div>

                        <p class="col-span-7">
                            {{ orphan.sponsor.phone_number }}
                        </p>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 rtl:!font-semibold">
                            {{ $t('the_zone') }}
                        </div>

                        <p class="col-span-7">
                            {{ orphan.family?.zone?.name || '————' }}
                        </p>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 rtl:!font-semibold">
                            {{ $t('age') }}
                        </div>

                        <p class="col-span-7">
                            {{ $tc('age_years', orphan.orphan.age, { count: String(orphan.orphan.age) }) }}
                        </p>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 rtl:!font-semibold">
                            {{ $t('pants_size') }}
                        </div>

                        <p class="col-span-7">
                            {{ orphan.orphan.pants_size || '————' }}
                        </p>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 rtl:!font-semibold">
                            {{ $t('shirt_size') }}
                        </div>

                        <p class="col-span-7">
                            {{ orphan.orphan.shirt_size || '————' }}
                        </p>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 rtl:!font-semibold">
                            {{ $t('shoes_size') }}
                        </div>

                        <p class="col-span-7">
                            {{ orphan.orphan.shoes_size || '————' }}
                        </p>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('clothes_shop_location') }}
                        </div>

                        <div class="col-span-7">
                            <shop-address-field
                                v-model:address="orphan.eid_suit.clothes_shop_address"
                                v-model:location="orphan.eid_suit.clothes_shop_location"
                                :disabled="
                                    orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id
                                "
                                :select_location_label="$t('select_location')"
                                @update:address="handleUpdate(orphan, 'clothes_shop_address')"
                                @update:location="handleUpdate(orphan, 'clothes_shop_location')"
                            >
                            </shop-address-field>
                        </div>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('shoes_shop_location') }}
                        </div>

                        <div class="col-span-7">
                            <shop-address-field
                                v-model:address="orphan.eid_suit.shoes_shop_address"
                                v-model:location="orphan.eid_suit.shoes_shop_location"
                                :disabled="
                                    orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id
                                "
                                :select_location_label="$t('select_location')"
                                @update:address="handleUpdate(orphan, 'shoes_shop_address')"
                                @update:location="handleUpdate(orphan, 'shoes_shop_location')"
                            >
                            </shop-address-field>
                        </div>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('designated_member') }}
                        </div>

                        <members-filter-drop-down
                            v-model="orphan.eid_suit.user_id"
                            :disabled="orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id"
                            class="col-span-7"
                            @focusin="selectOrphan(orphan)"
                            @focusout="deSelectOrphan(orphan)"
                            @update:model-value="handleUpdate(orphan, 'user_id')"
                        >
                        </members-filter-drop-down>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('clothes_shop_name') }}
                        </div>

                        <base-combobox
                            id="clothes_shop_name"
                            v-model="orphan.eid_suit.clothes_shop_name"
                            :disabled="orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id"
                            :load-options="loadShopOwnerNames"
                            :options="[]"
                            class="col-span-7 mt-0"
                            create-option
                            @focusin="selectOrphan(orphan)"
                            @focusout="deSelectOrphan(orphan)"
                            @update:model-value="handleUpdate(orphan, 'clothes_shop_name')"
                        ></base-combobox>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('clothes_shop_phone_number') }}
                        </div>

                        <base-combobox
                            id="clothes_shop_phone_number"
                            v-model="orphan.eid_suit.clothes_shop_phone_number"
                            :disabled="orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id"
                            :load-options="loadShopOwnerPhoneNumbers"
                            :options="[]"
                            class="col-span-7 mt-0"
                            create-option
                            @focusin="selectOrphan(orphan)"
                            @focusout="deSelectOrphan(orphan)"
                            @update:model-value="handleUpdate(orphan, 'clothes_shop_phone_number')"
                        ></base-combobox>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('shoes_shop_name') }}
                        </div>

                        <base-combobox
                            id="shoes_shop_name"
                            v-model="orphan.eid_suit.shoes_shop_name"
                            :disabled="orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id"
                            :load-options="loadShopOwnerNames"
                            :options="[]"
                            class="col-span-7 mt-0"
                            create-option
                            @focusin="selectOrphan(orphan)"
                            @focusout="deSelectOrphan(orphan)"
                            @update:model-value="handleUpdate(orphan, 'shoes_shop_name')"
                        ></base-combobox>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('shoes_shop_phone_number') }}
                        </div>

                        <base-combobox
                            id="shoes_shop_phone_number"
                            v-model="orphan.eid_suit.shoes_shop_phone_number"
                            :disabled="orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id"
                            :load-options="loadShopOwnerPhoneNumbers"
                            :options="[]"
                            class="col-span-7 mt-0"
                            create-option
                            @focusin="selectOrphan(orphan)"
                            @focusout="deSelectOrphan(orphan)"
                            @update:model-value="handleUpdate(orphan, 'shoes_shop_phone_number')"
                        ></base-combobox>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('pants_completed') }}
                        </div>

                        <base-form-switch class="col-span-7">
                            <base-form-switch-input
                                v-model="orphan.eid_suit.pants_completed"
                                :disabled="
                                    orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id
                                "
                                type="checkbox"
                                @focusin="selectOrphan(orphan)"
                                @focusout="deSelectOrphan(orphan)"
                                @mouseenter="selectOrphan(orphan)"
                                @mouseleave="deSelectOrphan(orphan)"
                                @update:model-value="handleUpdate(orphan, 'pants_completed')"
                            ></base-form-switch-input>
                        </base-form-switch>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('shirt_completed') }}
                        </div>

                        <base-form-switch class="col-span-7">
                            <base-form-switch-input
                                v-model="orphan.eid_suit.shirt_completed"
                                :disabled="
                                    orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id
                                "
                                type="checkbox"
                                @focusin="selectOrphan(orphan)"
                                @focusout="deSelectOrphan(orphan)"
                                @mouseenter="selectOrphan(orphan)"
                                @mouseleave="deSelectOrphan(orphan)"
                                @update:model-value="handleUpdate(orphan, 'shirt_completed')"
                            ></base-form-switch-input>
                        </base-form-switch>
                    </div>

                    <div class="col-span-12 grid grid-cols-12 items-center gap-2">
                        <div class="col-span-5 mt-1 rtl:!font-semibold">
                            {{ $t('shoes_completed') }}
                        </div>

                        <base-form-switch class="col-span-7">
                            <base-form-switch-input
                                v-model="orphan.eid_suit.shoes_completed"
                                :disabled="
                                    orphan.eid_suit.user_id && $page.props.auth.user.id !== orphan.eid_suit.user_id
                                "
                                type="checkbox"
                                @focusin="selectOrphan(orphan)"
                                @focusout="deSelectOrphan(orphan)"
                                @mouseenter="selectOrphan(orphan)"
                                @mouseleave="deSelectOrphan(orphan)"
                                @update:model-value="handleUpdate(orphan, 'shoes_completed')"
                            ></base-form-switch-input>
                        </base-form-switch>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
