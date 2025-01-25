<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { useOrphansStore } from '@/stores/orphans'
import { Link } from '@inertiajs/vue3'
import { watch } from 'vue'

import EditableRow from '@/Pages/Tenant/occasions/eid-suit/EditableRow.vue'
import MapCell from '@/Pages/Tenant/occasions/eid-suit/MapCell.vue'

import BaseAlert from '@/Components/Base/Alert/BaseAlert.vue'
import TheAlertDismissButton from '@/Components/Base/Alert/TheAlertDismissButton.vue'
import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatCurrency, hasPermission, loadShopOwnerNames, loadShopOwnerPhoneNumbers } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
    showWarningAlert: boolean
    notifiableUserName: string
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showLocationAddressModal', 'showSuccessNotification', 'selectOrphan', 'deselectOrphan'])

const orphansStore = useOrphansStore()

const checkAll = ($event) => {
    const orphans = props.orphans.data.map((orphan) => orphan.id)

    if ($event.target.checked) {
        // If checked, add all orphans to selectedFamilies
        if (orphansStore.orphans.length) {
            // Avoid duplication by filtering out existing ones
            orphansStore.orphans = [...new Set([...orphansStore.orphans, ...orphans])]
        } else {
            orphansStore.orphans = orphans
        }
    } else {
        // If unchecked, remove the current orphans from selectedFamilies
        orphansStore.orphans = orphansStore.orphans.filter((id) => !orphans.includes(id))
    }
}

watch(
    () => props.showWarningAlert,
    () => {
        if (props.showWarningAlert) {
            document.getElementById(useOrphansStore().selectedOrphan)?.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'start'
            })
        }
    }
)
</script>

<template>
    <base-form-switch class="intro-y -mb-2 mt-6 text-lg @3xl:hidden">
        <base-form-switch-input
            id="check_all"
            :checked="orphansStore.orphans.length"
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
                <div v-if="showWarningAlert && useOrphansStore().selectedOrphan === orphan.id">
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
                                {{ $t('update_orphan_eid_suit_infos', { name: notifiableUserName }) }}
                            </span>

                            <the-alert-dismiss-button @click="dismiss">
                                <svg-loader class="stroke-red-900 dark:!stroke-white" name="icon-x"></svg-loader>
                            </the-alert-dismiss-button>
                        </div>
                    </base-alert>
                </div>

                <base-form-switch-input
                    v-model="orphansStore.orphans"
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

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('the_sponsor') }}
                        </div>
                        {{ orphan.sponsor.name }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('sponsor_phone_number') }}
                        </div>
                        {{ orphan.sponsor.phone_number }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.address') }}
                        </div>
                        {{ orphan.family.address }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('the_zone') }}
                        </div>
                        {{ orphan.family?.zone?.name }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('clothes_shop_name') }}
                        </div>

                        <div class="w-full">
                            <editable-row
                                :load-options="loadShopOwnerNames"
                                :orphan
                                field="clothes_shop_name"
                                view="mobile"
                                @select-orphan="emit('selectOrphan', orphan.orphan.id)"
                                @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
                                @show-success-notification="emit('showSuccessNotification')"
                            ></editable-row>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('clothes_shop_phone_number') }}
                        </div>

                        <div class="mt-2 w-full">
                            <editable-row
                                :load-options="loadShopOwnerPhoneNumbers"
                                :orphan
                                field="clothes_shop_phone_number"
                                view="mobile"
                                @select-orphan="emit('selectOrphan', orphan.orphan.id)"
                                @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
                                @show-success-notification="emit('showSuccessNotification')"
                            ></editable-row>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('clothes_shop_location') }}
                        </div>

                        <div class="mt-2 w-fit">
                            <map-cell
                                :orphan
                                shop-type="clothes"
                                @show-location-address-modal="emit('showLocationAddressModal', $event)"
                            ></map-cell>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('shoes_shop_name') }}
                        </div>

                        <div class="w-full">
                            <editable-row
                                :load-options="loadShopOwnerNames"
                                :orphan
                                field="shoes_shop_name"
                                view="mobile"
                                @select-orphan="emit('selectOrphan', orphan.orphan.id)"
                                @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
                                @show-success-notification="emit('showSuccessNotification')"
                            ></editable-row>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('shoes_shop_phone_number') }}
                        </div>

                        <div class="w-full">
                            <editable-row
                                :load-options="loadShopOwnerPhoneNumbers"
                                :orphan
                                field="shoes_shop_phone_number"
                                view="mobile"
                                @select-orphan="emit('selectOrphan', orphan.orphan.id)"
                                @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
                                @show-success-notification="emit('showSuccessNotification')"
                            ></editable-row>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('shoes_shop_location') }}
                        </div>

                        <div class="mt-2 w-fit">
                            <map-cell
                                :orphan
                                shop-type="shoes"
                                @show-location-address-modal="emit('showLocationAddressModal', $event)"
                            ></map-cell>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="mb-2 rtl:!font-semibold">
                            {{ $t('notes') }}
                        </div>

                        <editable-row
                            :orphan
                            field="note"
                            view="mobile"
                            @select-orphan="emit('selectOrphan', orphan.orphan.id)"
                            @deselect-orphan="emit('deselectOrphan', orphan.orphan.id)"
                            @show-success-notification="emit('showSuccessNotification')"
                        ></editable-row>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
