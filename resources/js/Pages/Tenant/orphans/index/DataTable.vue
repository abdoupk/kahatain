<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t, getLocale } from '@/utils/i18n'

const familyStatusFilter = computed(() => {
    return `family_status.${getLocale()}`
})

defineProps<{ orphans: PaginationData<OrphansIndexResource>; params: IndexParams }>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
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
                            {{ $t('the_child') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions[familyStatusFilter]"
                            class="text-center"
                            sortable
                            @click="emit('sort', familyStatusFilter)"
                        >
                            {{ $t('family_status') }}
                        </the-table-th>

                        <the-table-th class="text-center"
                            >{{ $t('validation.attributes.sponsor.health_status') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions && params.directions['academic_level.id']"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'academic_level.id')"
                            >{{ $t('validation.attributes.sponsor.academic_level') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.birth_date"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'birth_date')"
                            >{{ $t('validation.attributes.date_of_birth') }}
                        </the-table-th>

                        <the-table-th v-if="hasPermission(['update_orphans', 'delete_orphans'])" class="text-center">
                            {{ $t('actions') }}
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
                                class="font-medium"
                            >
                                {{ orphan.name }}
                            </Link>

                            <span v-else> {{ orphan.name }}</span>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            {{ orphan.family_status ? $t(`family_statuses.${orphan.family_status}`) : '————' }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            {{ orphan.health_status }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            {{ orphan.academic_level }}

                            <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                                {{ orphan.academic_level_phase }}
                            </div>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ formatDate(orphan.birth_date, 'long') }}
                        </the-table-td>

                        <the-table-td-actions v-if="hasPermission(['update_orphans', 'delete_orphans'])">
                            <div class="flex items-center justify-center">
                                <Link
                                    v-if="hasPermission('update_orphans')"
                                    :href="route('tenant.orphans.edit', orphan.id)"
                                    class="me-3 flex items-center"
                                    @click.prevent="emit('showEditModal', orphan.id)"
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                    {{ $t('edit') }}
                                </Link>
                                <a
                                    v-if="hasPermission('delete_orphans')"
                                    class="flex items-center text-danger"
                                    href="javascript:void(0)"
                                    @click="emit('showDeleteModal', orphan.id)"
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-trash-can" />
                                    {{ $t('delete') }}
                                </a>
                            </div>
                        </the-table-td-actions>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
            <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <Link :href="route('tenant.orphans.show', orphan.id)" class="me-3 truncate text-lg font-medium">
                            {{ orphan.name }}
                        </Link>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            {{ $t(`family_statuses.${orphan.family_status}`) }}
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="w-3/4">
                            <p class="line-clamp-2 font-medium">{{ orphan.note }}</p>
                            <div
                                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                            >
                                {{ formatDate(orphan.birth_date, 'long') }}
                            </div>
                        </div>
                        <div class="flex w-1/4 items-center justify-end">
                            <Link
                                v-if="hasPermission('edit_orphans')"
                                :href="route('tenant.orphans.edit', orphan.id)"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                >{{ $t('edit') }}
                            </Link>
                            <a
                                v-if="hasPermission('delete_orphans')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', orphan.id)"
                            >
                                {{ $t('delete') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
