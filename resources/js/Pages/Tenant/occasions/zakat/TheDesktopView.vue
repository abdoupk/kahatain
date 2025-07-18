<script lang="ts" setup>
import type { IndexParams, PaginationData, ZakatFamiliesResource } from '@/types/types'

import { useZakatStore } from '@/stores/zakat'
import { Link } from '@inertiajs/vue3'

import BaseFormCheckInput from '@/Components/Base/form/form-check/BaseFormCheckInput.vue'
import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { formatCurrency, formatDate } from '@/utils/helper'

const props = defineProps<{
    families: PaginationData<ZakatFamiliesResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])

const zakatStore = useZakatStore()

const checkAll = ($event) => {
    // Get all family IDs from props.families
    const families = props.families.data.map((family) => family.id)

    if ($event.target.checked) {
        // If checked, add all families to selectedFamilies
        if (zakatStore.zakat.families.length) {
            // Avoid duplication by filtering out existing ones
            zakatStore.zakat.families = [...new Set([...zakatStore.zakat.families, ...families])]
        } else {
            zakatStore.zakat.families = families
        }
    } else {
        // If unchecked, remove the current families from selectedFamilies
        zakatStore.zakat.families = zakatStore.zakat.families.filter((id) => !families.includes(id))
    }
}
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden @3xl:mb-4 @3xl:block @3xl:overflow-x-auto">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start">
                        <base-form-check-input
                            :checked="zakatStore.zakat.families.length"
                            type="checkbox"
                            @change="checkAll"
                        ></base-form-check-input>
                    </the-table-th>

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
                        :direction="params.directions && params.directions['aggregate_zakat_benefit']"
                        class="!w-32 text-center"
                        sortable
                        @click="emit('sort', 'aggregate_zakat_benefit')"
                    >
                        {{ $t('aggregate_zakat_benefit') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.last_updated_at"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'last_updated_at')"
                    >
                        {{ $t('last_updated_at') }}
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
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="family in families.data" :key="family.id" class="intro-x">
                    <the-table-td class="w-16">
                        <base-form-check-input
                            v-model="zakatStore.zakat.families"
                            :value="family.id"
                            type="checkbox"
                        ></base-form-check-input>
                    </the-table-td>

                    <the-table-td class="!w-24 truncate">
                        <Link
                            v-if="family.sponsor.id"
                            :href="route('tenant.sponsors.show', family.sponsor.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ family.sponsor.name }}
                        </Link>

                        <p v-else class="font-medium rtl:!font-semibold">{{ family.sponsor.name }}</p>
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
                            {{ formatCurrency(family.aggregate_zakat_benefit) }}
                        </div>
                    </the-table-td>

                    <the-table-td class="w-40 text-center">
                        <div class="whitespace-nowrap">
                            {{ formatDate(family.last_updated_at, 'long') }}
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
