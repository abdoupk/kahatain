<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { familiesFilters } from '@/constants/filters'
import { familiesSorts } from '@/constants/sorts'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $tc } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/families/index/DataTable.vue'))

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
    families: PaginationData<FamiliesIndexResource>
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

const showDeletionError = ref<boolean>(false)

const selectedFamilyId = ref<string>('')

const deletionReason = ref<string>('')

const closeDeleteModal = () => {
    deleteModalStatus.value = false

    selectedFamilyId.value = ''

    deleteProgress.value = false
}

const sort = (field: string) => handleSort(field, params.value)

const deleteFamily = () => {
    if (deletionReason.value.length < 20) {
        showDeletionError.value = true
    } else {
        router.put(
            route('tenant.families.destroy', selectedFamilyId.value),
            { reason: deletionReason.value },
            {
                preserveScroll: true,
                onStart: () => {
                    deleteProgress.value = true
                },
                onSuccess: () => {
                    if (props.families.meta.last_page < params.value.page) {
                        params.value.page = params.value.page - 1
                    }

                    getDataForIndexPages(route('tenant.families.index'), params.value, {
                        onStart: () => {
                            closeDeleteModal()
                        },
                        onFinish: () => {
                            showSuccessNotification.value = true

                            showDeletionError.value = false

                            deletionReason.value = ''

                            setTimeout(() => {
                                showSuccessNotification.value = false
                            }, 2000)
                        },
                        preserveScroll: true,
                        preserveState: true
                    })
                }
            }
        )
    }
}

const showDeleteModal = (familyId: string) => {
    selectedFamilyId.value = familyId

    deleteModalStatus.value = true
}
</script>

<template>
    <Head :title="$t('the_families')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable="hasPermission('export_families')"
                :filters="familiesFilters"
                :pagination-data="families"
                :params="params"
                :title="$t('list', { attribute: $t('the_families') })"
                :url="route('tenant.families.index')"
                entries="families"
                export-pdf-url="tenant.families.export.pdf"
                export-xlsx-url="tenant.families.export.xlsx"
                filterable
                searchable
                :sortableFields="familiesSorts"
                sortable
                @change-filters="params.filters = $event"
            >
                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('create_families')"
                        class="me-2 shadow-md"
                        variant="primary"
                        @click.prevent="router.get(route('tenant.families.create'))"
                    >
                        {{ $tc('add new', 0, { attribute: $t('family') }) }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="families.data.length > 0">
                <data-table :families :params @showDeleteModal="showDeleteModal" @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="families"
                    :params
                    :url="route('tenant.families.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <delete-modal :deleteProgress :open="deleteModalStatus" @close="closeDeleteModal" @delete="deleteFamily">
                <div class="mt-2 text-slate-500">
                    <slot>
                        {{ $t('Do you really want to delete this record?') }} <br />
                        {{ $t('please_provide_the_reason_for_deleting_this_family') }}
                    </slot>
                </div>

                <div class="text-start">
                    <base-form-label for="deletion_reason">
                        {{ $t('deletion_reason') }}
                    </base-form-label>

                    <base-form-text-area id="deletion_reason" v-model="deletionReason" rows="4"></base-form-text-area>

                    <base-input-error
                        v-if="showDeletionError"
                        :message="$t('validation.min.string', { min: 20, attribute: $t('deletion_reason') })"
                    ></base-input-error>
                </div>
            </delete-modal>

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
