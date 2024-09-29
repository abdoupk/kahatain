<script lang="ts" setup>
import type { IndexParams, PaginationData, RolesIndexResource } from '@/types/types'

import { useRolesStore } from '@/stores/roles'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

const RoleCreateEditSlideOver = defineAsyncComponent(
    () => import('@/Pages/Tenant/roles/create/RoleCreateEditSlideOver.vue')
)

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/roles/index/DataTable.vue'))

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
    roles: PaginationData<RolesIndexResource>
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

const createEditSlideOverStatus = ref<boolean>(false)

const rolesStore = useRolesStore()

const deleteModalStatus = ref<boolean>(false)

const deleteProgress = ref<boolean>(false)

const showSuccessNotification = ref<boolean>(false)

const selectedRoleId = ref<string>('')

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedRoleId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteRole = () => {
    router.delete(route('tenant.roles.destroy', selectedRoleId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.roles.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.roles.index'), params.value, {
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

const showDeleteModal = (roleId: string) => {
    selectedRoleId.value = roleId

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    rolesStore.$reset()

    createEditSlideOverStatus.value = true
}

const showEditModal = async (roleId: string) => {
    selectedRoleId.value = roleId

    await rolesStore.getRole(roleId)

    createEditSlideOverStatus.value = true
}
</script>

<template>
    <Head :title="$t('the_roles')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="[]"
                :pagination-data="roles"
                :params="params"
                :title="$t('list', { attribute: $t('the_roles') })"
                :url="route('tenant.roles.index')"
                entries="roles"
                export-pdf-url=""
                export-xlsx-url=""
                searchable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button class="me-2 shadow-md" variant="primary" @click.prevent="showCreateModal">
                        {{ $tc('add new', 1, { attribute: $t('role') }) }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="roles.data.length > 0">
                <data-table
                    :params
                    :roles
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-edit-modal="showEditModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="roles"
                    :params
                    :url="route('tenant.roles.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteRole"
            ></delete-modal>

            <role-create-edit-slide-over
                :open="createEditSlideOverStatus"
                @close="createEditSlideOverStatus = false"
            ></role-create-edit-slide-over>

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
