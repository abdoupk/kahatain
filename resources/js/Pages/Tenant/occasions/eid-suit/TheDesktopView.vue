<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import EditableRows from '@/Pages/Tenant/occasions/eid-suit/EditableRows.vue'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { formatCurrency } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-y-hidden overflow-x-scroll @3xl:block">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start"> #</the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'name')"
                    >
                        {{ $t('the_child') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['pants_size']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'pants_size')"
                    >
                        {{ $t('pants_size') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['shoes_size']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'shoes_size')"
                    >
                        {{ $t('shoes_size') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['shirt_size']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'shirt_size')"
                    >
                        {{ $t('shirt_size') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['birth_date']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'birth_date')"
                    >
                        {{ $t('age') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['family.income_rate']"
                        class="!w-32 text-center"
                        sortable
                        @click="emit('sort', 'family.income_rate')"
                    >
                        {{ $t('income_rate') }}
                    </the-table-th>

                    <the-table-th>{{ $t('clothes_shop_name') }}</the-table-th>

                    <the-table-th>{{ $t('clothes_shop_phone_number') }}</the-table-th>

                    <the-table-th>{{ $t('clothes_shop_location') }}</the-table-th>

                    <the-table-th>{{ $t('shoes_shop_name') }}</the-table-th>

                    <the-table-th>{{ $t('shoes_shop_phone_number') }}</the-table-th>

                    <the-table-th>{{ $t('shoes_shop_location') }}</the-table-th>

                    <the-table-th>{{ $t('designated_member') }}</the-table-th>

                    <the-table-th>{{ $t('validation.attributes.note') }}</the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['sponsor.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'sponsor.name')"
                    >
                        {{ $t('the_sponsor') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.sponsor.phone_number') }}
                    </the-table-th>

                    <the-table-th class="text-start">{{ $t('validation.attributes.address') }}</the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(orphan, index) in orphans.data" :key="orphan.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (orphans.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-24 !max-w-24 truncate">
                        <Link :href="route('tenant.orphans.show', orphan.orphan.id)" class="font-medium">
                            {{ orphan.orphan.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ orphan.orphan.pants_size }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ orphan.orphan.shoes_size }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ orphan.orphan.shirt_size }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <span v-if="orphan.orphan.age > 0">{{
                            $tc('age_years', orphan.orphan.age, { count: String(orphan.orphan.age) })
                        }}</span>

                        <span v-else> {{ $t('low_than_one_year') }}</span>
                    </the-table-td>

                    <the-table-td class="text-center">
                        <div class="whitespace-nowrap">
                            {{ formatCurrency(orphan.family.income_rate) }}
                        </div>
                    </the-table-td>

                    <editable-rows
                        :orphan
                        @showLocationAddressModal="$emit('showLocationAddressModal', $event)"
                        @showSuccessNotification="$emit('showSuccessNotification')"
                    ></editable-rows>

                    <the-table-td class="!min-w-24 !max-w-24 truncate">
                        <Link :href="route('tenant.sponsors.show', orphan.sponsor.id)" class="font-medium">
                            <base-tippy :content="orphan.sponsor.name">
                                {{ orphan.sponsor.name }}
                            </base-tippy>
                        </Link>
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ orphan.sponsor.phone_number }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <base-tippy :content="orphan.family.address">
                            {{ orphan.family.address }}
                        </base-tippy>

                        <Link
                            :href="route('tenant.zones.index') + `?show=${orphan.family.zone?.id}`"
                            class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                        >
                            {{ orphan.family.zone?.name }}
                        </Link>
                    </the-table-td>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>
</template>
