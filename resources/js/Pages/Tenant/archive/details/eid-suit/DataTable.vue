<script lang="ts" setup>
import type { EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { $t, $tc } from '@/utils/i18n'

defineProps<{ orphans: PaginationData<EidSuitOrphansResource>; params: IndexParams }>()
</script>

<template>
    <div class="@container">
        <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th class="text-start">
                            {{ $t('the_child') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('pants_size') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('shoes_size') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('shirt_size') }}
                        </the-table-th>

                        <the-table-th class="text-start">
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
            <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            <Link :href="route('tenant.orphans.show', orphan.orphan.id)" class="font-medium">
                                {{ orphan.orphan.name }}
                            </Link>
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            <span v-if="orphan.orphan.age > 0">{{
                                $tc('age_years', orphan.orphan.age, { count: String(orphan.orphan.age) })
                            }}</span>

                            <span v-else> {{ $t('low_than_one_year') }}</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-12 gap-2">
                        <p class="col-span-12 text-base">
                            <Link
                                v-if="orphan.sponsor.id"
                                :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                                class="font-medium rtl:font-semibold"
                            >
                                {{ orphan.sponsor?.name }}
                            </Link>
                        </p>

                        <div class="col-span-12 mt-2 grid grid-cols-12 gap-2">
                            <div class="col-span-12 grid grid-cols-12 gap-2">
                                <p class="col-span-4 rtl:font-semibold">{{ $t('shoes_size') }}</p>

                                <p class="col-span-8">
                                    {{ orphan.orphan.shoes_size }}
                                </p>
                            </div>

                            <div class="col-span-12 grid grid-cols-12 gap-2">
                                <p class="col-span-4 rtl:font-semibold">{{ $t('shirt_size') }}</p>

                                <p class="col-span-8">
                                    {{ orphan.orphan.shirt_size }}
                                </p>
                            </div>

                            <div class="col-span-12 grid grid-cols-12 gap-2">
                                <p class="col-span-4 rtl:font-semibold">{{ $t('pants_size') }}</p>

                                <p class="col-span-8">
                                    {{ orphan.orphan.pants_size }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="mt-2 flex h-fit w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            <base-tippy :content="$t('sponsor_phone_number')">
                                {{ orphan.sponsor?.phone_number }}
                            </base-tippy>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
