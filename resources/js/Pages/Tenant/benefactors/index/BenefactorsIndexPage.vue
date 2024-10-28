<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { benefactorsFilters } from '@/constants/filters'
import { useBenefactorsStore } from '@/stores/benefactors'
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref, watchEffect } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import SponsorshipCreateEditModal from '@/Pages/Tenant/benefactors/SponsorshipCreateEditModal.vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/benefactors/index/DataTable.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const DeleteModal = defineAsyncComponent(() => import('@/Components/Global/DeleteModal.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

const benefactorShowModal = defineAsyncComponent(() => import('@/Pages/Tenant/benefactors/BenefactorShowModal.vue'))

const BenefactorCreateEditModal = defineAsyncComponent(
    () => import('@/Pages/Tenant/benefactors/BenefactorCreateEditModal.vue')
)

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    benefactors: PaginationData<FamiliesIndexResource>
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

const benefactorsStore = useBenefactorsStore()

const sponsorshipsStore = useSponsorshipsStore()

const deleteModalStatus = ref<boolean>(false)

const showSuccessNotification = ref<boolean>(false)

const createEditModalStatus = ref<boolean>(false)

const createEditSponsorshipModalStatus = ref<boolean>(false)

const showModalStatus = ref<boolean>(false)

const deleteProgress = ref<boolean>(false)

const selectedBenefactorId = ref<string>('')

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedBenefactorId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteBenefactor = () => {
    router.delete(route('tenant.benefactors.destroy', selectedBenefactorId.value), {
        preserveScroll: true,
        onStart: () => {
            deleteProgress.value = true
        },
        onSuccess: () => {
            if (props.benefactors.meta.last_page < params.value.page) {
                params.value.page = params.value.page - 1
            }

            getDataForIndexPages(route('tenant.benefactors.index'), params.value, {
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

const showEditModal = async (benefactorId: string) => {
    selectedBenefactorId.value = benefactorId

    await benefactorsStore.getBenefactor(benefactorId)

    createEditModalStatus.value = true
}

const showDetailsModal = async (benefactorId: string | null) => {
    if (benefactorId) {
        selectedBenefactorId.value = benefactorId

        await benefactorsStore.getBenefactorDetails(benefactorId)

        showModalStatus.value = true
    }
}

const showCreateModal = () => {
    benefactorsStore.$reset()

    createEditModalStatus.value = true
}

const showAddNewSponsorshipModal = () => {
    sponsorshipsStore.$reset()

    createEditSponsorshipModalStatus.value = true
}

const showDeleteModal = (benefactorId: string) => {
    selectedBenefactorId.value = benefactorId

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
    <Head :title="$t('the_benefactors')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="benefactorsFilters"
                :pagination-data="benefactors"
                :params="params"
                :title="$t('list', { attribute: $t('the_benefactors') })"
                :url="route('tenant.benefactors.index')"
                entries="benefactors"
                export-pdf-url=""
                export-xlsx-url=""
                filterable
                searchable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('create_benefactors')"
                        class="me-2 shadow-md"
                        variant="primary"
                        @click.prevent="showCreateModal"
                    >
                        {{ $tc('add new', 1, { attribute: $t('benefactor') }) }}
                    </base-button>

                    <base-button class="me-2" @click.prevent="showAddNewSponsorshipModal">
                        <base-tippy :content="$tc('add new', 0, { attribute: $t('sponsorship') })">
                            <svg-loader name="icon-plus"></svg-loader>
                        </base-tippy>
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="benefactors.data.length > 0">
                <data-table
                    :benefactors
                    :params
                    @showDeleteModal="showDeleteModal"
                    @sort="sort"
                    @show-details-modal="showDetailsModal"
                    @show-edit-modal="showEditModal"
                ></data-table>

                <the-table-footer
                    :pagination-data="benefactors"
                    :params
                    :url="route('tenant.benefactors.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal
                :deleteProgress
                :open="deleteModalStatus"
                @close="closeDeleteModal"
                @delete="deleteBenefactor"
            ></delete-modal>

            <benefactor-create-edit-modal
                :open="createEditModalStatus"
                @close="createEditModalStatus = false"
            ></benefactor-create-edit-modal>

            <sponsorship-create-edit-modal
                :open="createEditSponsorshipModalStatus"
                @close="createEditSponsorshipModalStatus = false"
            ></sponsorship-create-edit-modal>

            <benefactor-show-modal
                :open="showModalStatus"
                :title="$t('modal_show_title', { attribute: $t('the_benefactor') })"
                @close="showModalStatus = false"
            ></benefactor-show-modal>

            <success-notification
                :open="showSuccessNotification"
                :title="$tc('successfully_trashed', 0, { attribute: $t('the_benefactor') })"
            ></success-notification>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
