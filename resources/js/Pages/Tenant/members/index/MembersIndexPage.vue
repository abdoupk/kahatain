<script lang="ts" setup>
import type { IndexParams, MembersIndexResource, PaginationData } from '@/types/types'

import { useMembersStore } from '@/stores/members'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref, watchEffect } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

const MemberCreateModal = defineAsyncComponent(() => import('@/Pages/Tenant/members/MemberCreateModal.vue'))

const MemberShowModal = defineAsyncComponent(() => import('@/Pages/Tenant/members/MemberShowModal.vue'))

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/members/index/DataTable.vue'))

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
    members: PaginationData<MembersIndexResource>
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

const selectedMemberId = ref<string>('')

const membersStore = useMembersStore()

const createUpdateSlideoverStatus = ref<boolean>(false)

const showModalStatus = ref<boolean>(false)

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedMemberId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteMember = () => {
    router.delete(route('tenant.members.destroy', selectedMemberId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.members.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.members.index'), params.value, {
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

const showDeleteModal = (memberId: string) => {
    selectedMemberId.value = memberId

    deleteModalStatus.value = true
}

const showCreateModal = () => {
    membersStore.$reset()

    createUpdateSlideoverStatus.value = true
}

const showEditModal = (memberId: string) => {
    selectedMemberId.value = memberId

    membersStore.getMember(memberId)

    createUpdateSlideoverStatus.value = true
}

const showDetailsModal = async (memberId: string | null) => {
    if (memberId) {
        selectedMemberId.value = memberId

        await membersStore.getMemberDetails(memberId)

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
    <Head :title="$t('the_members')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="[]"
                :pagination-data="members"
                :params="params"
                :title="$t('list', { attribute: $t('the_members') })"
                :url="route('tenant.members.index')"
                entries="members"
                export-pdf-url=""
                export-xlsx-url=""
                searchable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('create_members')"
                        class="me-2 shadow-md"
                        variant="primary"
                        @click.prevent="showCreateModal"
                    >
                        {{ $tc('add new', 1, { attribute: $t('member') }) }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="members.data.length > 0">
                <data-table
                    :members
                    :params
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-edit-modal="showEditModal"
                    @show-details-modal="showDetailsModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="members"
                    :params
                    :url="route('tenant.members.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteMember"
            ></delete-modal>

            <member-create-modal
                :open="createUpdateSlideoverStatus"
                @close="createUpdateSlideoverStatus = false"
            ></member-create-modal>

            <member-show-modal
                :open="showModalStatus"
                :title="$t('modal_show_title', { attribute: $t('the_member') })"
                @close="showModalStatus = false"
            ></member-show-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 1, { attribute: $t('the_member') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
