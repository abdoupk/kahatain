<script lang="ts" setup>
import type { IndexParams, NeedsIndexResource, PaginationData } from '@/types/types'

import { needsFilters } from '@/constants/filters'
import { needsSorts } from '@/constants/sorts'
import { useNeedsStore } from '@/stores/needs'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref, watchEffect } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

const NeedShowModal = defineAsyncComponent(() => import('@/Pages/Tenant/needs/NeedShowModal.vue'))

const NeedCreateUpdateModal = defineAsyncComponent(
    () => import('@/Pages/Tenant/needs/create/NeedCreateUpdateModal.vue')
)

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/needs/index/DataTable.vue'))

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
    needs: PaginationData<NeedsIndexResource>
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

const selectedNeedId = ref<string>('')

const updateModalStatus = ref<boolean>(false)

const showTheNeedable = ref(false)

const needsStore = useNeedsStore()

const showModalStatus = ref<boolean>(false)

const showDetailsModal = async (needId: string | null) => {
    if (needId) {
        selectedNeedId.value = needId

        await needsStore.getNeedDetails(needId)

        showModalStatus.value = true
    }
}

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedNeedId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteNeed = () => {
    router.delete(route('tenant.needs.destroy', selectedNeedId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.needs.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.needs.index'), params.value, {
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

const showDeleteModal = (needId: string) => {
    selectedNeedId.value = needId

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    needsStore.$reset()

    updateModalStatus.value = true

    showTheNeedable.value = true
}

const showEditModal = (needId: string) => {
    selectedNeedId.value = needId

    needsStore.getNeed(needId)

    showTheNeedable.value = false

    updateModalStatus.value = true
}

watchEffect(async () => {
    const searchParams = new URLSearchParams(window.location.search)

    if (searchParams.has('show')) {
        setTimeout(async () => {
            await showDetailsModal(searchParams.get('show'))
        }, 800)
    }
})
</script>

<template>
    <Head :title="$t('the_needs')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="needsFilters"
                :pagination-data="needs"
                :params="params"
                :sortableFields="needsSorts"
                :title="$t('list', { attribute: $t('the_needs') })"
                :url="route('tenant.needs.index')"
                entries="needs"
                export-pdf-url=""
                export-xlsx-url=""
                searchable
                sortable
                filterable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('create_needs')"
                        class="me-2 whitespace-nowrap shadow-md"
                        variant="primary"
                        @click.prevent="showCreateModal"
                    >
                        {{ $tc('add new', 1, { attribute: $t('demand') }) }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="needs.data.length > 0">
                <data-table
                    :needs
                    :params
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-edit-modal="showEditModal"
                    @show-details-modal="showDetailsModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="needs"
                    :params
                    :url="route('tenant.needs.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteNeed"
            ></delete-modal>

            <need-create-update-modal
                :open="updateModalStatus"
                :show-the-needable="showTheNeedable"
                @close="updateModalStatus = false"
            ></need-create-update-modal>

            <need-show-modal
                :open="showModalStatus"
                :title="$t('modal_show_title', { attribute: $t('the_needs') })"
                @close="showModalStatus = false"
            ></need-show-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 0, { attribute: $t('the_demand') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
