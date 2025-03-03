<script lang="ts" setup>
import type { IndexParams, InventoryIndexResource, PaginationData } from '@/types/types'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, formatNumber, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    items: PaginationData<InventoryIndexResource>
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
                        {{ $t('the_item') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.qty"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'qty')"
                    >
                        {{ $t('validation.attributes.qty') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.created_at"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'created_at')"
                    >
                        {{ $t('validation.attributes.created_at') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.notes') }}
                    </the-table-th>

                    <the-table-th
                        v-if="hasPermission(['view_item', 'delete_from_inventory', 'update_inventory'])"
                        class="text-center"
                    >
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(item, index) in items.data" :key="item.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (items.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <a
                            class="font-medium rtl:!font-semibold"
                            href="#"
                            @click.prevent="emit('showDetailsModal', item.id)"
                        >
                            {{ item.name }}
                        </a>
                    </the-table-td>

                    <the-table-td class="max-w-40 text-center">
                        {{ formatNumber(item.qty) }} {{ $t(item.unit) }}
                    </the-table-td>

                    <the-table-td class="w-48 text-center">
                        {{ formatDate(item.created_at, 'full') }}
                    </the-table-td>

                    <the-table-td class="text-center">
                        <base-tippy v-if="item.note" :content="item.note" as="div">
                            <svg-loader class="mx-auto block" name="icon-note"></svg-loader>
                        </base-tippy>

                        <span v-else class="mx-auto block text-center">————</span>
                    </the-table-td>

                    <the-table-td-actions
                        v-if="hasPermission(['delete_from_inventory', 'update_inventory', 'view_item'])"
                    >
                        <div class="flex items-center justify-center">
                            <a
                                v-if="hasPermission(['view_item'])"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="emit('showDetailsModal', item.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission(['update_inventory'])"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="emit('showEditModal', item.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                {{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission(['delete_from_inventory'])"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', item.id)"
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
