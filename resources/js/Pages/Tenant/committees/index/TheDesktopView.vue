<script lang="ts" setup>
import type { CommitteesIndexResource, IndexParams, PaginationData } from '@/types/types'

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
    committees: PaginationData<CommitteesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
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
                        {{ $t('the_committee') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.description') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.members_count"
                        class="text-center"
                        sortable
                        @click.prevent="emit('sort', 'members_count')"
                    >
                        {{ $t('members_count') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.created_at"
                        class="text-center"
                        sortable
                        @click.prevent="emit('sort', 'created_at')"
                    >
                        {{ $t('added_at') }}
                    </the-table-th>

                    <the-table-th v-if="hasPermission(['update_committees', 'delete_committees'])" class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(committee, index) in committees.data" :key="committee.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (committees.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <a
                            class="font-medium rtl:!font-semibold"
                            href="#"
                            @click.prevent="emit('showDetailsModal', committee.id)"
                        >
                            {{ committee.name }}
                        </a>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-start">
                        <base-tippy :content="committee.description" :options="{ placement: 'auto-start' }">
                            {{ committee.description }}
                        </base-tippy>
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ committee.members_count }}
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ committee.created_at }}
                    </the-table-td>

                    <the-table-td-actions
                        v-if="hasPermission(['update_committees', 'delete_committees', 'view_committees'])"
                    >
                        <div class="flex items-center justify-center">
                            <a
                                v-if="hasPermission('view_committees')"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click="emit('showDetailsModal', committee.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_committees')"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click="emit('showEditModal', committee.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                {{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission('delete_committees')"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', committee.id)"
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
