<script lang="ts" setup>
import type { IndexParams, PaginationData, SchoolEntryOrphansResource } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { formatCurrency, formatDate } from '@/utils/helper'

defineProps<{
    orphans: PaginationData<SchoolEntryOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="intro-y !z-30 col-span-12 mb-2 hidden !overflow-auto @3xl:block">
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
                        :direction="params.directions && params.directions['academic_level.i_id']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'academic_level.i_id')"
                    >
                        {{ $t('academic_level') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['academic_average']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'academic_average')"
                    >
                        {{ $t('year_average') }}
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

                    <the-table-th class="text-start">{{ $t('validation.attributes.address') }}</the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['family.income_rate']"
                        class="!w-32 text-center"
                        sortable
                        @click="emit('sort', 'family.income_rate')"
                    >
                        {{ $t('income_rate') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['family.last_updated_at']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'family.last_updated_at')"
                    >
                        {{ $t('last_updated_at') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(orphan, index) in orphans.data" :key="orphan.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (orphans.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-24 !max-w-24 truncate">
                        <Link
                            :href="route('tenant.orphans.show', orphan.orphan.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ orphan.orphan.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <template v-if="orphan.orphan.academic_level">
                            <base-tippy :content="orphan.orphan.academic_level">
                                {{ orphan.orphan.academic_level }}
                            </base-tippy>

                            <p class="mt-0.5 block whitespace-nowrap text-xs text-slate-500">
                                {{ orphan.orphan?.academic_phase }}
                            </p>
                        </template>

                        <p v-else class="ms-8">-</p>
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{
                            orphan.orphan.academic_average ? parseFloat(orphan.orphan.academic_average).toFixed(2) : '-'
                        }}
                    </the-table-td>

                    <the-table-td class="!min-w-24 !max-w-24 truncate">
                        <Link
                            :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ orphan.sponsor.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="text-center">
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

                    <the-table-td class="text-center">
                        <div class="whitespace-nowrap">
                            {{ formatCurrency(orphan.family.income_rate) }}
                        </div>
                    </the-table-td>

                    <the-table-td class="w-40 text-center">
                        <div class="whitespace-nowrap">
                            {{ formatDate(orphan.family.last_updated_at, 'long') }}
                        </div>
                    </the-table-td>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>
</template>
