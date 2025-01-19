<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import MapCell from '@/Pages/Tenant/occasions/eid-suit/MapCell.vue'
import RowCombobox from '@/Pages/Tenant/occasions/eid-suit/RowCombobox.vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, hasPermission, loadShopOwnerNames } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['showLocationAddressModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
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
                            <row-combobox
                                :id="`clothes_shop_name_${orphan.orphan.id}`"
                                :has-error
                                :load-options="loadShopOwnerNames"
                                :max-length="255"
                                :model-value="{
                                    id: orphan.eid_suit['clothes_shop_name'] ?? '',
                                    name: orphan.eid_suit['clothes_shop_name'] ?? ''
                                }"
                                :options="[]"
                                class="ms-4 w-1/2"
                            ></row-combobox>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('clothes_shop_phone_number') }}
                        </div>

                        <div class="w-full">
                            <row-combobox
                                :id="`clothes_shop_name_${orphan.orphan.id}`"
                                :has-error
                                :load-options="loadShopOwnerNames"
                                :max-length="255"
                                :model-value="{
                                    id: orphan.eid_suit['clothes_shop_name'] ?? '',
                                    name: orphan.eid_suit['clothes_shop_name'] ?? ''
                                }"
                                :options="[]"
                                class="ms-4 w-1/2"
                            ></row-combobox>
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
                            <row-combobox
                                :id="`shoes_shop_name_${orphan.orphan.id}`"
                                :has-error
                                :load-options="loadShopOwnerNames"
                                :max-length="255"
                                :model-value="{
                                    id: orphan.eid_suit['shoes_shop_name'] ?? '',
                                    name: orphan.eid_suit['shoes_shop_name'] ?? ''
                                }"
                                :options="[]"
                                class="ms-4 w-1/2"
                            ></row-combobox>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-4 w-28 rtl:!font-semibold">
                            {{ $t('shoes_shop_phone_number') }}
                        </div>

                        <div class="w-full">
                            <row-combobox
                                :id="`shoes_shop_name_${orphan.orphan.id}`"
                                :has-error
                                :load-options="loadShopOwnerNames"
                                :max-length="255"
                                :model-value="{
                                    id: orphan.eid_suit['shoes_shop_name'] ?? '',
                                    name: orphan.eid_suit['shoes_shop_name'] ?? ''
                                }"
                                :options="[]"
                                class="ms-4 w-1/2"
                            ></row-combobox>
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
                </div>
            </div>
        </div>
    </div>
</template>
