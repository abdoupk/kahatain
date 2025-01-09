<script lang="ts" setup>
import type { EidAlAdhaFamiliesResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { formatCurrency } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<EidAlAdhaFamiliesResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort', 'change-status'])
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start"> #</the-table-th>

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

                    <the-table-th
                        :direction="params.directions && params.directions['address.zone.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'address.zone.name')"
                        >{{ $t('validation.attributes.address') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['branch.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'branch.name')"
                        >{{ $t('the_branch') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['orphans_count']"
                        class="!w-32 text-center"
                        sortable
                        @click="emit('sort', 'orphans_count')"
                    >
                        {{ $t('children_count') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['total_income']"
                        class="!w-32 text-center"
                        sortable
                        @click="emit('sort', 'total_income')"
                    >
                        {{ $t('incomes.label.total_income') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['income_rate']"
                        class="!w-32 text-center"
                        sortable
                        @click="emit('sort', 'income_rate')"
                    >
                        {{ $t('income_rate') }}
                    </the-table-th>

                    <the-table-th>{{ $t('actions') }}</the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(family, index) in families.data" :key="family.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (families.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-24 !max-w-24 truncate">
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
                        <div class="whitespace-nowrap">
                            {{ family.orphans_count }}
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

                    <the-table-td-actions class="min-w-32">
                        <base-form-select
                            :value="family.status"
                            @change="
                                emit('change-status', {
                                    id: family.id,
                                    status: $event.target.value
                                })
                            "
                        >
                            <option selected value="">{{ $t('filters.select_an_option') }}</option>
                            <option value="benefit">{{ $t('benefit') }}</option>
                            <option value="dont_benefit">{{ $t('dont_benefit') }}</option>
                            <option value="sacrificed">
                                {{ $t('sacrificed') }}
                            </option>
                            <option value="meat">{{ $t('meat') }}</option>
                            <option value="benefactor">{{ $t('benefactor') }}</option>
                        </base-form-select>
                    </the-table-td-actions>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>
</template>
