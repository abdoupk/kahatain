<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

import { sponsorsFilters } from '@/constants/filters'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/sponsors/index/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const DeleteModal = defineAsyncComponent(() => import('@/Components/Global/DeleteModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
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

const selectedSponsorId = ref<string>('')

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedSponsorId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteSponsor = () => {
    router.delete(route('tenant.sponsors.destroy', selectedSponsorId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.sponsors.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.sponsors.index'), params.value, {
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

const showDeleteModal = (sponsorId: string) => {
    selectedSponsorId.value = sponsorId

    deleteModalStatus.value = true
}
</script>

<template>
    <Head :title="$t('the_sponsors')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_orphans')"
                :filters="sponsorsFilters"
                :pagination-data="sponsors"
                :params="params"
                :title="$t('list', { attribute: $t('the_sponsors') })"
                :url="route('tenant.sponsors.index')"
                entries="sponsors"
                export-pdf-url="tenant.sponsors.export.pdf"
                export-xlsx-url="tenant.sponsors.export.xlsx"
                filterable
                searchable
                @change-filters="params.filters = $event"
            ></the-table-header>

            <template v-if="sponsors.data.length > 0">
                <data-table :params :sponsors @showDeleteModal="showDeleteModal" @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="sponsors"
                    :params
                    :url="route('tenant.sponsors.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteSponsor"
            ></delete-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 0, { attribute: $t('the_sponsor') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
