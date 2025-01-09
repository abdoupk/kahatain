<script lang="ts" setup>
import type { BranchesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { branchedFilters } from '@/constants/filters'
import { branchesSorts } from '@/constants/sorts'
import { useBranchesStore } from '@/stores/branches'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref, watchEffect } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

const BranchCreateEditModal = defineAsyncComponent(
    () => import('@/Pages/Tenant/branches/create/BranchCreateEditModal.vue')
)

const BranchShowModal = defineAsyncComponent(() => import('@/Pages/Tenant/branches/BranchShowModal.vue'))

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/branches/index/DataTable.vue'))

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
    branches: PaginationData<BranchesIndexResource>
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

const deleteModalStatus = ref<boolean>(false)

const createEditModalStatus = ref<boolean>(false)

const showModalStatus = ref<boolean>(false)

const deleteProgress = ref<boolean>(false)

const showSuccessNotification = ref<boolean>(false)

const selectedBranchId = ref<string>('')

const branchesStore = useBranchesStore()

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedBranchId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteBranch = () => {
    router.delete(route('tenant.branches.destroy', selectedBranchId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.branches.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.branches.index'), params.value, {
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

const showDeleteModal = (branchId: string) => {
    selectedBranchId.value = branchId

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    branchesStore.$reset()

    createEditModalStatus.value = true
}

const showEditModal = async (branchId: string) => {
    selectedBranchId.value = branchId

    await branchesStore.getBranch(branchId)

    createEditModalStatus.value = true
}

const showDetailsModal = async (branchID: string | null) => {
    if (branchID) {
        selectedBranchId.value = branchID

        await branchesStore.getBranchDetails(branchID)

        showModalStatus.value = true
    }
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
    <Head :title="$t('branches')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="branchedFilters"
                :pagination-data="branches"
                :params="params"
                :title="$t('list', { attribute: $t('branches') })"
                :url="route('tenant.branches.index')"
                entries="branches"
                export-pdf-url=""
                export-xlsx-url=""
                filterable
                :sortableFields="branchesSorts"
                sortable
                searchable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('create_branches')"
                        class="me-2 whitespace-nowrap shadow-md"
                        variant="primary"
                        @click.prevent="showCreateModal"
                    >
                        {{ $tc('add new', 1, { attribute: $t('branch') }) }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="branches.data.length > 0">
                <data-table
                    :branches
                    :params
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-edit-modal="showEditModal"
                    @show-details-modal="showDetailsModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="branches"
                    :params
                    :url="route('tenant.branches.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteBranch"
            ></delete-modal>

            <branch-create-edit-modal
                :open="createEditModalStatus"
                @close="createEditModalStatus = false"
            ></branch-create-edit-modal>

            <branch-show-modal
                :open="showModalStatus"
                :title="$t('modal_show_title', { attribute: $t('the_branch') })"
                @close="showModalStatus = false"
            ></branch-show-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 1, { attribute: $t('the_branch') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
