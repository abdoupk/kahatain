<script lang="ts" setup>
import type { FinancialTransactionsIndexResource, IndexParams, PaginationData } from '@/types/types'

import { financialFilters } from '@/constants/filters'
import { useFinancialTransactionsStore } from '@/stores/financial-transactions'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref, watchEffect } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

const FinancialShowModal = defineAsyncComponent(() => import('@/Pages/Tenant/financials/FinancialShowModal.vue'))

const FinancialTransactionCreateModal = defineAsyncComponent(
    () => import('@/Pages/Tenant/financials/create/FinancialTransactionCreateModal.vue')
)

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/financials/index/DataTable.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const DeleteModal = defineAsyncComponent(() => import('@/Components/Global/DeleteModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    finances: PaginationData<FinancialTransactionsIndexResource>
    params: IndexParams
}>()

const params = ref<IndexParams>({
    perPage: props.params.perPage,
    page: props.params.page,
    directions: props.params.directions,
    fields: props.params.fields,
    filters: props.params.filters,
    search: props.params.search
})

const financialTransactionsStore = useFinancialTransactionsStore()

const deleteModalStatus = ref<boolean>(false)

const deleteProgress = ref<boolean>(false)

const showSuccessNotification = ref<boolean>(false)

const selectedFinancialTransactionId = ref<string>('')

const createEditModalStatus = ref<boolean>(false)

const showModalStatus = ref<boolean>(false)

const showDetailsModal = async (financialTransactionId: string | null) => {
    if (financialTransactionId) {
        selectedFinancialTransactionId.value = financialTransactionId

        await financialTransactionsStore.getFinancialTransactionDetails(financialTransactionId)

        showModalStatus.value = true
    }
}

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedFinancialTransactionId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteFinancialTransaction = () => {
    router.delete(route('tenant.financial.destroy', selectedFinancialTransactionId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.finances.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.financial.index'), params.value, {
                onStart: () => {
                    closeDeleteModal()
                },
                onFinish: () => {
                    showSuccessNotification.value = true

                    setTimeout(() => {
                        showSuccessNotification.value = false
                    }, 2000)
                },
                preserveScroll: true,
                preserveState: true
            })
        }
    })
}

const showDeleteModal = (financeId: string) => {
    selectedFinancialTransactionId.value = financeId

    deleteModalStatus.value = true
}

const showCreateIncomeModal = () => {
    financialTransactionsStore.$reset()

    createEditModalStatus.value = true
}

const showCreateExpenseModal = () => {
    financialTransactionsStore.$reset()

    financialTransactionsStore.financialTransaction.type = 'expense'

    createEditModalStatus.value = true
}

const showEditModal = async (financialTransactionId: string) => {
    financialTransactionsStore.$reset()

    selectedFinancialTransactionId.value = financialTransactionId

    await financialTransactionsStore.getFinancialTransaction(financialTransactionId)

    if (financialTransactionsStore.financialTransaction.amount) {
        if (financialTransactionsStore.financialTransaction.amount > 0) {
            financialTransactionsStore.financialTransaction.type = 'income'
        } else {
            financialTransactionsStore.financialTransaction.type = 'expense'

            financialTransactionsStore.financialTransaction.amount = Math.abs(
                financialTransactionsStore.financialTransaction.amount
            )
        }
    }

    createEditModalStatus.value = true
}

watchEffect(async () => {
    const searchParams = new URLSearchParams(window.location.search)

    if (searchParams.has('show')) {
        setTimeout(async () => {
            await showDetailsModal(searchParams.get('show'))
        }, 1000)
    }
})
</script>

<template>
    <Head :title="$t('the_financial_transactions')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_financial_transactions')"
                :filters="financialFilters"
                :pagination-data="finances"
                :params="params"
                :title="$t('the_financial_transactions')"
                :url="route('tenant.financial.index')"
                entries="finances"
                export-pdf-url="tenant.financial.export.pdf"
                export-xlsx-url="tenant.financial.export.xlsx"
                searchable
                filterable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('create_financial_transactions')"
                        class="me-2 shadow-md"
                        variant="primary"
                        @click.prevent="showCreateIncomeModal"
                    >
                        {{ $tc('add new', 1, { attribute: $t('income') }) }}
                    </base-button>

                    <base-button
                        v-if="hasPermission('create_financial_transactions')"
                        class="me-2 shadow-md"
                        variant="outline-danger"
                        @click.prevent="showCreateExpenseModal"
                    >
                        {{ $tc('add new', 1, { attribute: $t('expense') }) }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="finances.data.length > 0">
                <data-table
                    :finances
                    :params
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-details-modal="showDetailsModal"
                    @show-edit-modal="showEditModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="finances"
                    :params
                    :url="route('tenant.financial.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteFinancialTransaction"
            ></delete-modal>

            <financial-transaction-create-modal
                :open="createEditModalStatus"
                @close="createEditModalStatus = false"
            ></financial-transaction-create-modal>

            <financial-show-modal
                :open="showModalStatus"
                :title="$t('modal_show_title', { attribute: $t('the_financial_transactions') })"
                @close="showModalStatus = false"
            ></financial-show-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 0, { attribute: $t('the_family') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
