<script lang="ts" setup>
import type { FinancialTransactionsIndexResource, IndexParams, PaginationData } from '@/types/types'

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

import { formatCurrency, formatDate, hasPermission } from '@/utils/helper'
import { $t, getLocale } from '@/utils/i18n'

defineProps<{
    finances: PaginationData<FinancialTransactionsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showDetailsModal', 'showEditModal'])
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start"> #</the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions?.['creator.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'creator.name')"
                    >
                        {{ $t('receiving_member') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.amount"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'amount')"
                    >
                        {{ $t('the_amount') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions[`specification.${getLocale()}`]"
                        class="text-center"
                        sortable
                        @click="emit('sort', `specification.${getLocale()}`)"
                    >
                        {{ $t('validation.attributes.specification') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.date"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'date')"
                    >
                        {{ $t('validation.attributes.date') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.description') }}
                    </the-table-th>

                    <the-table-th
                        v-if="
                            hasPermission([
                                'delete_financial_transactions',
                                'update_financial_transactions',
                                'view_financial_transactions'
                            ])
                        "
                        class="text-center"
                    >
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(finance, index) in finances.data" :key="finance.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (finances.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link
                            v-if="finance.receiver"
                            :href="route('tenant.members.index') + `?show=${finance.receiver.id}`"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ finance.receiver.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <div :class="finance.amount < 0 ? 'text-danger' : 'text-success'">
                            {{ formatCurrency(Math.abs(finance.amount)) }}
                        </div>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ $t(finance.specification) }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ formatDate(finance.date, 'long') }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <base-tippy :content="finance.description">
                            <svg-loader class="mx-auto block h-6 w-6" name="icon-note"></svg-loader>
                        </base-tippy>
                    </the-table-td>

                    <the-table-td-actions
                        v-if="
                            hasPermission([
                                'delete_financial_transactions',
                                'update_financial_transactions',
                                'view_financial_transactions'
                            ])
                        "
                    >
                        <div class="flex items-center justify-center">
                            <a
                                v-if="hasPermission(['view_financial_transactions'])"
                                class="me-3 flex items-center"
                                href="#"
                                @click.prevent="emit('showDetailsModal', finance.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission(['update_financial_transactions'])"
                                class="me-3 flex items-center"
                                href="#"
                                @click.prevent="emit('showEditModal', finance.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                {{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission(['delete_financial_transactions'])"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', finance.id)"
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
