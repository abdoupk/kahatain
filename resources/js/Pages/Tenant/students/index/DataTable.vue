<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    orphans: unknown
    params: unknown
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="@container">
        <div class="intro-y !z-30 col-span-12 overflow-auto">
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
                            {{ $t('the_orphan') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['academic_level.i_id']"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'academic_level.i_id')"
                            >{{ $t('validation.attributes.sponsor.academic_level') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['institution.name']"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'institution.name')"
                            >{{ $t('validation.attributes.institution') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.academic_average"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'academic_average')"
                        >
                            {{ $t('general_average') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['sponsor.name']"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'sponsor.name')"
                        >
                            {{ $t('the_sponsor') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('sponsor_phone_number') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['family.zone.name']"
                            class="text-start"
                            sortable
                            @click="emit('sort', 'family.zone.name')"
                        >
                            {{ $t('validation.attributes.address') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['family.branch.name']"
                            class="text-start"
                            sortable
                            @click="emit('sort', 'family.branch.name')"
                        >
                            {{ $t('the_branch') }}
                        </the-table-th>
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
                                class="font-medium rtl:!font-semibold"
                            >
                                {{ orphan.name }}
                            </Link>

                            <span v-else> {{ orphan.name }}</span>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            {{ orphan.academicLevel }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            <base-tippy v-if="orphan.institution" :content="orphan.institution">
                                {{ orphan.institution }}
                            </base-tippy>

                            <span v-else> ———— </span>
                        </the-table-td>

                        <the-table-td class="whitespace-nowrap text-center">
                            {{ orphan.academic_average }}
                        </the-table-td>

                        <the-table-td class="whitespace-nowrap text-center">
                            {{ orphan.sponsor.name }}
                        </the-table-td>

                        <the-table-td class="whitespace-nowrap text-center">
                            {{ orphan.sponsor.phone_number }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            <base-tippy :content="orphan.address">
                                {{ orphan.address }}
                            </base-tippy>

                            <Link
                                :href="route('tenant.zones.index') + `?show=${orphan.zone?.id}`"
                                class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                            >
                                {{ orphan.zone?.name }}
                            </Link>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            <base-tippy :content="orphan.branch?.name">
                                <Link :href="route('tenant.branches.index') + `?show=${orphan.branch?.id}`">
                                    {{ orphan.branch?.name }}
                                </Link>
                            </base-tippy>
                        </the-table-td>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>
    </div>
</template>
