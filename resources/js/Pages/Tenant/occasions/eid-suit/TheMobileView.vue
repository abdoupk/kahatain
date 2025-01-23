<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { useOrphansStore } from '@/stores/orphans'
import { Link } from '@inertiajs/vue3'

import EditableRow from '@/Pages/Tenant/occasions/eid-suit/EditableRow.vue'
import MapCell from '@/Pages/Tenant/occasions/eid-suit/MapCell.vue'

import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, hasPermission, loadShopOwnerNames, loadShopOwnerPhoneNumbers } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['showLocationAddressModal', 'showSuccessNotification'])

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
        <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box px-5 pb-5 pt-3">
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
                            @show-success-notification="emit('showSuccessNotification')"
                        ></editable-row>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
