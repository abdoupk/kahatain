<script lang="ts" setup>
import type { BabiesMilkAndDiapersResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<BabiesMilkAndDiapersResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start"> #</the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('the_child') }}
                    </the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('baby_milk_type') }}
                    </the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('baby_milk_quantity') }}
                    </the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('diapers_type') }}
                    </the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('diapers_quantity') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.age') }}
                    </the-table-th>

                    <the-table-th class="text-start">
                        {{ $t('the_sponsor') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.sponsor.phone_number') }}
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
                            v-if="orphan.orphan.id"
                            :href="route('tenant.orphans.show', orphan.orphan.id)"
                            class="font-medium"
                        >
                            {{ orphan.orphan.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        {{ orphan.orphan.baby_milk_type }}
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ orphan.orphan.baby_milk_quantity }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        {{ orphan.orphan.diapers_type }}
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ orphan.orphan.diapers_quantity }}
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ orphan.orphan.age }}
                    </the-table-td>

                    <the-table-td class="!min-w-24 !max-w-24 truncate">
                        <Link
                            v-if="orphan.sponsor.id"
                            :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                            class="font-medium"
                        >
                            {{ orphan.sponsor.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ orphan.sponsor.phone_number }}
                    </the-table-td>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>
</template>
