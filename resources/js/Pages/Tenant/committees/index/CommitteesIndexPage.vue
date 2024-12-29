<script lang="ts" setup>
import type { CommitteesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { committeesFilters } from '@/constants/filters'
import { committeesSorts } from '@/constants/sorts'
import { useCommitteesStore } from '@/stores/committees'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref, watchEffect } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/committees/index/DataTable.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const DeleteModal = defineAsyncComponent(() => import('@/Components/Global/DeleteModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

const committeeShowModal = defineAsyncComponent(() => import('@/Pages/Tenant/committees/CommitteeShowModal.vue'))

const CommitteeCreateEditModal = defineAsyncComponent(
    () => import('@/Pages/Tenant/committees/create/CommitteeCreateEditModal.vue')
)

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    committees: PaginationData<CommitteesIndexResource>
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

const committeesStore = useCommitteesStore()

const deleteModalStatus = ref<boolean>(false)

const showSuccessNotification = ref<boolean>(false)

const createEditModalStatus = ref<boolean>(false)

const showModalStatus = ref<boolean>(false)

const deleteProgress = ref<boolean>(false)

const selectedCommitteeId = ref<string>('')

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedCommitteeId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteCommittee = () => {
    router.delete(route('tenant.committees.destroy', selectedCommitteeId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.committees.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.committees.index'), params.value, {
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

const showEditModal = async (committeeId: string) => {
    selectedCommitteeId.value = committeeId

    await committeesStore.getCommittee(committeeId)

    createEditModalStatus.value = true
}

const showDetailsModal = async (committeeId: string | null) => {
    if (committeeId) {
        selectedCommitteeId.value = committeeId

        await committeesStore.getCommitteeDetails(committeeId)

        showModalStatus.value = true
    }
}

const showCreateModal = () => {
    committeesStore.$reset()

    createEditModalStatus.value = true
}

const showDeleteModal = (committeeId: string) => {
    selectedCommitteeId.value = committeeId

    deleteModalStatus.value = true
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
    <Head :title="$t('the_committees')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="committeesFilters"
                :pagination-data="committees"
                :params="params"
                :title="$t('list', { attribute: $t('the_committees') })"
                :url="route('tenant.committees.index')"
                entries="committees"
                export-pdf-url=""
                export-xlsx-url=""
                filterable
                searchable
                :sortableFields="committeesSorts"
                sortable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('create_committees')"
                        class="me-2 shadow-md"
                        variant="primary"
                        @click.prevent="showCreateModal"
                    >
                        {{ $tc('add new', 0, { attribute: $t('committee') }) }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="committees.data.length > 0">
                <data-table
                    :committees
                    :params
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-details-modal="showDetailsModal"
                    @show-edit-modal="showEditModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="committees"
                    :params
                    :url="route('tenant.committees.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteCommittee"
            ></delete-modal>

            <committee-create-edit-modal
                :open="createEditModalStatus"
                @close="createEditModalStatus = false"
            ></committee-create-edit-modal>

            <committee-show-modal
                :open="showModalStatus"
                :title="$t('modal_show_title', { attribute: $t('the_committee') })"
                @close="showModalStatus = false"
            ></committee-show-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 0, { attribute: $t('the_committee') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
