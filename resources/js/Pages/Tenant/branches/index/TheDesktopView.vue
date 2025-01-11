<script lang="ts" setup>
import type { BranchesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    branches: PaginationData<BranchesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-auto @4xl:block lg:overflow-visible">
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
                        {{ $t('the_branch') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['president.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'president.name')"
                    >
                        {{ $t('branch_president') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['city.ar_name']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'city.ar_name')"
                        >{{ $t('location') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.families_count"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'families_count')"
                    >
                        {{ $t('families_count') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.members_count"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'members_count')"
                    >
                        {{ $t('members_count') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.created_at"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'created_at')"
                    >
                        {{ $t('validation.attributes.created_at') }}
                    </the-table-th>

                    <the-table-th v-if="hasPermission(['update_branches', 'delete_branches'])" class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(branch, index) in branches.data" :key="branch.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (branches.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <a class="font-medium" href="#" @click.prevent="emit('showDetailsModal', branch.id)">
                            <base-tippy :content="branch.name">
                                {{ branch.name }}
                            </base-tippy>
                        </a>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <Link :href="route('tenant.families.index', branch.president?.id)" class="font-medium">
                            {{ branch.president?.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate text-center">
                        <base-tippy :content="branch.city">
                            {{ branch.city }}
                        </base-tippy>
                    </the-table-td>

                    <the-table-td>
                        <div class="whitespace-nowrap text-center">
                            {{ branch.families_count }}
                        </div>
                    </the-table-td>

                    <the-table-td>
                        <div class="whitespace-nowrap text-center">
                            {{ branch.members_count }}
                        </div>
                    </the-table-td>

                    <the-table-td>
                        <div class="whitespace-nowrap text-center">
                            {{ branch.created_at }}
                        </div>
                    </the-table-td>

                    <the-table-td-actions v-if="hasPermission(['update_branches', 'delete_branches', 'view_branches'])">
                        <div class="flex items-center justify-center">
                            <a
                                v-if="hasPermission('view_branches')"
                                class="me-3 flex items-center"
                                href="#"
                                @click.prevent="emit('showDetailsModal', branch.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_branches')"
                                class="me-3 flex items-center"
                                href="#"
                                @click.prevent="emit('showEditModal', branch.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                {{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission('delete_branches')"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', branch.id)"
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
</template>
