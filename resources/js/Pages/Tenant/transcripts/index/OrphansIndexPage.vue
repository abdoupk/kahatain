<script lang="ts" setup>
import type { IndexParams, OrphansTranscriptsIndexResource, PaginationData } from '@/types/types'

import { orphansFilters } from '@/constants/filters'
import { useTranscriptsStore } from '@/stores/transcripts'
import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TranscriptCreateEditModal from '@/Pages/Tenant/transcripts/create/TranscriptCreateEditModal.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort, hasPermission } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/transcripts/index/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const SuccessNotification = defineAsyncComponent(() => import('@/Components/Global/SuccessNotification.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    orphans: PaginationData<OrphansTranscriptsIndexResource>
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

const showSuccessNotification = ref<boolean>(false)

const transcriptStore = useTranscriptsStore()

const sort = (field: string) => handleSort(field, params.value)

const showEditModal = (transcriptId: string) => {
    transcriptStore.$reset()

    transcriptStore.getTranscript(transcriptId)

    createEditModalStatus.value = true
}

const createEditModalStatus = ref<boolean>(false)

const showCreateModal = async ($event: { trimester: string; orphan: OrphansTranscriptsIndexResource }) => {
    transcriptStore.$reset()

    transcriptStore.transcript.trimester = $event.trimester

    transcriptStore.transcript.orphan_id = $event.orphan.id

    transcriptStore.transcript.academic_level = $event.orphan.academic_level

    await transcriptStore.getTranscriptSubjects($event.orphan.id)

    createEditModalStatus.value = true
}
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
                :url="route('tenant.transcripts.index')"
                entries="orphans"
                export-pdf-url="tenant.orphans.export.pdf"
                export-xlsx-url="tenant.orphans.export.xlsx"
                filterable
                searchable
                @change-filters="params.filters = $event"
            ></the-table-header>

            <template v-if="orphans.data.length > 0">
                <data-table
                    :orphans
                    :params
                    @showEditModal="showEditModal"
                    @showCreateModal="showCreateModal"
                    @sort="sort"
                ></data-table>

                <the-table-footer
                    :pagination-data="orphans"
                    :params
                    :url="route('tenant.transcripts.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <transcript-create-edit-modal
                :open="createEditModalStatus"
                @close="createEditModalStatus = false"
            ></transcript-create-edit-modal>

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
