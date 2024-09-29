<script lang="ts" setup>
import type { IndexParams, PaginationData, SchoolEntryOrphansResource } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

defineProps<{ orphans: PaginationData<SchoolEntryOrphansResource>; params: IndexParams }>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <div class="intro-y col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible !z-30">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['orphan.name']"
                            class="text-start"
                            sortable
                            @click="emit('sort', 'orphan.name')"
                        >
                            {{ $t('the_child') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['orphan.academic_level']"
                            class="text-start"
                            sortable
                            @click="emit('sort', 'orphan.academic_level')"
                        >
                            {{ $t('academic_level') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['orphan.year_average']"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'orphan.year_average')"
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

                        <the-table-td class="max-w-40 truncate">
                            <template v-if="orphan.orphan.academic_level">
                                {{ orphan.orphan.academic_level }}
                                <p class="mt-0.5 block whitespace-nowrap text-xs text-slate-500">
                                    {{ orphan.orphan?.academic_phase }}
                                </p>
                            </template>

                            <p v-else class="ms-8">-</p>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{
                                orphan.orphan.last_year_average
                                    ? parseFloat(orphan.orphan.last_year_average).toFixed(2)
                                    : '-'
                            }}
                        </the-table-td>

                        <the-table-td class="!min-w-24 !max-w-24 truncate">
                            <Link :href="route('tenant.sponsors.show', orphan.sponsor.id)" class="font-medium">
                                {{ orphan.sponsor.name }}
                            </Link>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ orphan.sponsor.phone_number }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            {{ orphan.family.address }}

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

        <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
            <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            {{ orphan.orphan.name }}
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            {{ orphan.orphan.last_year_average }}
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="w-3/4">
                            <p class="truncate">
                                {{ orphan.sponsor.name }}

                                <span v-if="orphan.sponsor.phone_number" dir="ltr"
                                    >({{ orphan.sponsor.phone_number }})</span
                                >
                            </p>

                            <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                                {{ orphan.family.address }}
                            </div>
                            <div
                                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                            >
                                {{ orphan.orphan.academic_level }} ({{ orphan.orphan.academic_phase }})
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
