<script lang="ts" setup>
import type { IndexParams, MeatDistributionFamiliesResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { formatCurrency } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<MeatDistributionFamiliesResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden @3xl:mb-4 @3xl:block @3xl:overflow-x-auto">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start"> #</the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('the_sponsor') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.sponsor.phone_number') }}
                    </the-table-th>

                    <the-table-th class="text-start">{{ $t('validation.attributes.address') }}</the-table-th>

                    <the-table-th class="text-start">{{ $t('the_branch') }}</the-table-th>

                    <the-table-th class="!w-32 text-center">
                        {{ $t('children_count') }}
                    </the-table-th>

                    <the-table-th class="!w-32 text-center">
                        {{ $t('aggregate_white_meat_benefit') }}
                    </the-table-th>

                    <the-table-th class="!w-32 text-center">
                        {{ $t('aggregate_red_meat_benefit') }}
                    </the-table-th>

                    <the-table-th class="!w-32 text-center">
                        {{ $t('incomes.label.total_income') }}
                    </the-table-th>

                    <the-table-th class="!w-32 text-center">
                        {{ $t('income_rate') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(family, index) in families.data" :key="family.id" class="intro-x">
                    <the-table-td class="w-16"> {{ (families.meta.from ?? 0) + index }}</the-table-td>

                    <the-table-td class="!w-24 truncate">
                        <Link
                            v-if="family.sponsor.id"
                            :href="route('tenant.sponsors.show', family.sponsor.id)"
                            class="font-medium"
                        >
                            {{ family.sponsor.name }}
                        </Link>

                        <p v-else class="font-medium">{{ family.sponsor.name }}</p>
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ family.sponsor.phone_number }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <base-tippy :content="family.address">
                            {{ family.address }}
                        </base-tippy>

                        <Link
                            :href="route('tenant.zones.index') + `?show=${family.zone?.id}`"
                            class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                        >
                            {{ family.zone?.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <Link
                            :href="route('tenant.branches.index') + `?show=${family.branch?.id}`"
                            class="mt-0.5 block truncate whitespace-nowrap"
                        >
                            <base-tippy :content="family.branch?.name">
                                {{ family.branch?.name }}
                            </base-tippy>
                        </Link>
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ family.orphans_count }}
                    </the-table-td>

                    <the-table-td class="text-center">
                        <div class="whitespace-nowrap">
                            {{ family.aggregate_white_meat_benefit }}
                        </div>
                    </the-table-td>

                    <the-table-td class="text-center">
                        <div class="whitespace-nowrap">
                            {{ family.aggregate_red_meat_benefit }}
                        </div>
                    </the-table-td>

                    <the-table-td class="text-center">
                        <div class="whitespace-nowrap">
                            {{ formatCurrency(family.total_income) }}
                        </div>
                    </the-table-td>

                    <the-table-td class="text-center">
                        <div class="whitespace-nowrap">
                            {{ formatCurrency(family.income_rate) }}
                        </div>
                    </the-table-td>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>
</template>
