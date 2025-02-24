<script lang="ts" setup>
import type { FinancialTransactionsIndexResource, IndexParams, PaginationData } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    finances: PaginationData<FinancialTransactionsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showDeleteModal', 'showDetailsModal', 'showEditModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="finance in finances.data" :key="finance.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ $t(finance.specification) }}
                    </div>

                    <base-tippy
                        :class="
                            finance.amount < 0 ? 'text-danger  dark:bg-danger/20' : 'text-success dark:bg-success/20'
                        "
                        :content="$t('the_amount')"
                        class="ms-auto flex items-center rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold"
                    >
                        {{ formatCurrency(finance.amount) }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('receiving_member') }}
                        </div>
                        {{ finance.receiver?.name }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('created_by') }}
                        </div>
                        {{ finance.creator?.name }}
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('the date')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(finance.date, 'full') }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <a
                                v-if="hasPermission(['view_financial_transactions'])"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click="emit('showDetailsModal', finance.id)"
                            >
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission(['update_financial_transactions'])"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click="emit('showEditModal', finance.id)"
                            >
                                {{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission(['delete_financial_transactions'])"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', finance.id)"
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
