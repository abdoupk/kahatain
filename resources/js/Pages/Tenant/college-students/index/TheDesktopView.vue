<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    orphans: unknown
    params: unknown
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort'])
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start"> #</the-table-th>

                    <the-table-th
                        :direction="params.directions?.name"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'name')"
                    >
                        {{ $t('the_college_student') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['academic_level.id']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'academic_level.id')"
                        >{{ $t('validation.attributes.sponsor.academic_level') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['institution']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'institution')"
                        >{{ $t('university') }}
                    </the-table-th>

                    <the-table-th class="text-center">{{ $t('validation.attributes.phone_number') }}</the-table-th>

                    <the-table-th class="text-center">{{ $t('ccp') }}</the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(orphan, index) in orphans.data" :key="orphan.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (orphans.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link
                            v-if="hasPermission('view_orphans')"
                            :href="route('tenant.orphans.show', orphan.id)"
                            class="font-medium"
                        >
                            {{ orphan.name }}
                        </Link>

                        <span v-else> {{ orphan.name }}</span>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ orphan.academicLevel }}
                        </div>
                    </the-table-td>

                    <the-table-td class="max-w-20 truncate text-center">
                        {{ orphan.university || '————' }}
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ orphan.phone_number }}
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ orphan.ccp || '————' }}
                    </the-table-td>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>
</template>
