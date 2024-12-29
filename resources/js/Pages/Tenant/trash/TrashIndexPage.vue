<script lang="ts" setup>
import type { IndexParams, PaginationData, TrashIndexResource } from '@/types/types'

import { transcriptsSorts } from '@/constants/sorts'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import SuccessNotification from '@/Components/Global/SuccessNotification.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/trash/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const DeleteModal = defineAsyncComponent(() => import('@/Components/Global/DeleteModal.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    items: PaginationData<TrashIndexResource>
    params: IndexParams
}>()

const showSuccessNotification = ref<boolean>(false)

const successNotificationMessage = ref<string>('')

const params = ref<IndexParams>({
    perPage: props.params.perPage,
    page: props.params.page
})

const deleteModalStatus = ref<boolean>(false)

const deleteProgress = ref<boolean>(false)

const restore = (url: string) => {
    router.post(
        url,
        {},
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                router.get(
                    route('tenant.trash'),
                    {},
                    {
                        only: ['items'],
                        onSuccess: () => {
                            if (props.items.meta.last_page < params.value.page) {
                                params.value.page = params.value.page - 1
                            }

                            showSuccessNotification.value = true

                            successNotificationMessage.value = $t('successfully_restored')

                            setTimeout(() => {
                                showSuccessNotification.value = false
                            }, 1000)
                        },
                        replace: true,
                        preserveState: true,
                        preserveScroll: true
                    }
                )
            }
        }
    )
}

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    deleteProgress.value = false

    showSuccessNotification.value = true

    successNotificationMessage.value = $t('successfully_force_deleted')

    setTimeout(() => {
        showSuccessNotification.value = false
    }, 1000)
}

const selectedItem = ref()

const showDeleteModal = ({ id, url }: { id: string; url: string }) => {
    selectedItem.value = { id, url }

    deleteModalStatus.value = true
}

const deleteItem = () => {
    router.delete(route(selectedItem.value.url, selectedItem.value.id), {
        preserveScroll: true,
        preserveState: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            router.get(
                route('tenant.trash'),
                {},
                {
                    only: ['items'],
                    onSuccess: () => {
                        if (props.items.meta.last_page < params.value.page) {
                            params.value.page = params.value.page - 1
                        }

                        closeDeleteModal()
                    },
                    replace: true,
                    preserveState: true,
                    preserveScroll: true
                }
            )
        }
    })
}
</script>

<template>
    <Head :title="$t('the_trash')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="[]"
                :pagination-data="items"
                :params="params"
                :sortableFields="transcriptsSorts"
                :title="$t('list_trash')"
                :url="route('tenant.trash')"
                entries="items"
                export-pdf-url=""
                export-xlsx-url=""
                sortable
            >
            </the-table-header>

            <template v-if="items.data.length > 0">
                <data-table :items :params @restore="restore" @showDeleteModal="showDeleteModal"></data-table>

                <the-table-footer :pagination-data="items" :params :url="route('tenant.trash')"></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteItem"
            ></delete-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="successNotificationMessage"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
