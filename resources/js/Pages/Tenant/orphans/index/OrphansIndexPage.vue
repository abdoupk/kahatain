<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import { orphansFilters } from '@/constants/filters'
import { orphansSorts } from '@/constants/sorts'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/orphans/index/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const DeleteModal = defineAsyncComponent(() => import('@/Components/Global/DeleteModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    orphans: PaginationData<OrphansIndexResource>
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

const deleteProgress = ref<boolean>(false)

const showSuccessNotification = ref<boolean>(false)

const selectedOrphanId = ref<string>('')

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedOrphanId.value = ''

    deleteProgress.value = false
}

const deleteOrphan = () => {
    router.delete(route('tenant.orphans.destroy', selectedOrphanId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.orphans.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.orphans.index'), params.value, {
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

const showDeleteModal = (orphanId: string) => {
    selectedOrphanId.value = orphanId

    deleteModalStatus.value = true
}

const sort = (field: string) => handleSort(field, params.value)
</script>

<template>
    <Head :title="$t('the_orphans')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_orphans')"
                :filters="orphansFilters"
                :pagination-data="orphans"
                :params="params"
                :title="$t('list', { attribute: $t('the_orphans') })"
                :url="route('tenant.orphans.index')"
                entries="orphans"
                export-pdf-url="tenant.orphans.export.pdf"
                export-xlsx-url="tenant.orphans.export.xlsx"
                filterable
                searchable
                :sortableFields="orphansSorts"
                sortable
                @change-filters="params.filters = $event"
            ></the-table-header>

            <template v-if="orphans.data.length > 0">
                <data-table :orphans :params @showDeleteModal="showDeleteModal" @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="orphans"
                    :params
                    :url="route('tenant.orphans.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteOrphan"
            ></delete-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 0, { attribute: $t('the_orphan') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
