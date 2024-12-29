<script lang="ts" setup>
import type { IndexParams, InventoryIndexResource, PaginationData } from '@/types/types'

import { inventorySorts } from '@/constants/sorts'
import { useInventoryStore } from '@/stores/inventory'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref, watchEffect } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const ItemCreateEditModal = defineAsyncComponent(
    () => import('@/Pages/Tenant/inventory/create/ItemCreateEditModal.vue')
)

const ItemShowModal = defineAsyncComponent(() => import('@/Pages/Tenant/inventory/ItemShowModal.vue'))

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/inventory/index/DataTable.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseTippy = defineAsyncComponent(() => import('@/Components/Base/tippy/BaseTippy.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const DeleteModal = defineAsyncComponent(() => import('@/Components/Global/DeleteModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    items: PaginationData<InventoryIndexResource>
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

const selectedItemId = ref<string>('')

const inventoryStore = useInventoryStore()

const createUpdateModalStatus = ref<boolean>(false)

const showModalStatus = ref<boolean>(false)

const showDetailsModal = async (itemId: string | null) => {
    if (itemId) {
        selectedItemId.value = itemId

        await inventoryStore.getItemDetails(itemId)

        showModalStatus.value = true
    }
}

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedItemId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteItem = () => {
    router.delete(route('tenant.inventory.destroy', selectedItemId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.items.meta.last_page < params.value.page) {
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

const showDeleteModal = (itemId: string) => {
    selectedItemId.value = itemId

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    inventoryStore.$reset()

    inventoryStore.item.qty_for_family = null

    createUpdateModalStatus.value = true
}

const showCreateModalForBabyMilk = () => {
    inventoryStore.$reset()

    inventoryStore.item.type = 'baby_milk'

    inventoryStore.item.unit = 'piece'

    createUpdateModalStatus.value = true
}

const showCreateModalForDiapers = () => {
    inventoryStore.$reset()

    inventoryStore.item.type = 'diapers'

    inventoryStore.item.unit = 'piece'

    createUpdateModalStatus.value = true
}

const showEditModal = (itemID: string) => {
    selectedItemId.value = itemID

    inventoryStore.getItem(itemID)

    createUpdateModalStatus.value = true
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
    <Head :title="$t('the_inventory')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="[]"
                :pagination-data="items"
                :params="params"
                :sortableFields="inventorySorts"
                :title="$t('the_inventory')"
                :url="route('tenant.inventory.index')"
                entries="items"
                export-pdf-url=""
                export-xlsx-url=""
                searchable
                sortable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-tippy v-if="hasPermission('add_to_inventory')" :content="$t('add_new_item')">
                        <base-button class="me-2 shadow-md" variant="primary" @click.prevent="showCreateModal">
                            <svg-loader name="icon-plus"></svg-loader>
                        </base-button>
                    </base-tippy>

                    <base-tippy v-if="hasPermission('add_to_inventory')" :content="$t('add_baby_milk')">
                        <base-button
                            class="me-2 shadow-md"
                            variant="secondary"
                            @click.prevent="showCreateModalForBabyMilk"
                        >
                            <svg-loader name="icon-bottle-baby"></svg-loader>
                        </base-button>
                    </base-tippy>

                    <base-tippy v-if="hasPermission('add_to_inventory')" :content="$t('add_diapers')">
                        <base-button
                            class="me-2 shadow-md"
                            variant="secondary"
                            @click.prevent="showCreateModalForDiapers"
                        >
                            <svg-loader class="stroke-current stroke-1.5" name="icon-diapers"></svg-loader>
                        </base-button>
                    </base-tippy>
                </template>
            </the-table-header>

            <template v-if="items.data.length > 0">
                <data-table
                    :items
                    :params
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-edit-modal="showEditModal"
                    @show-details-modal="showDetailsModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="items"
                    :params
                    :url="route('tenant.inventory.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteItem"
            ></delete-modal>

            <item-create-edit-modal
                :open="createUpdateModalStatus"
                @close="createUpdateModalStatus = false"
            ></item-create-edit-modal>

            <item-show-modal
                :open="showModalStatus"
                :title="$t('modal_show_title', { attribute: $t('the_item') })"
                @close="showModalStatus = false"
            ></item-show-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 1, { attribute: $t('the_item') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
