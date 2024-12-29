<script lang="ts" setup>
import type { ArchiveOccasionType, EidSuitOrphansResource, IndexParams, PaginationData } from '@/types/types'

import { eidSuitsFilters } from '@/constants/filters'
import { eidSuitSorts } from '@/constants/sorts'
import { useSettingsStore } from '@/stores/settings'
import { Head, router } from '@inertiajs/vue3'
import { defineAsyncComponent, nextTick, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/occasions/eid-suit/DataTable.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const TheOccasionHint = defineAsyncComponent(() => import('@/Components/Global/TheOccasionHint.vue'))

const TheWarningModal = defineAsyncComponent(() => import('@/Components/Global/TheWarningModal.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    orphans: PaginationData<EidSuitOrphansResource>
    params: IndexParams
    archive: ArchiveOccasionType
}>()

const params = ref<IndexParams>({
    perPage: props.params.perPage,
    page: props.params.page,
    directions: props.params.directions,
    fields: props.params.fields,
    filters: props.params.filters,
    search: props.params.search
})

const exportable = ref(!!props.archive?.created_at && hasPermission('export_occasions'))

const loading = ref(false)

const loadingReset = ref(false)

const showWarningModalStatusForReset = ref(false)

const handleReset = () => {
    showWarningModalStatusForReset.value = true
}

const showWarningModalStatus = ref(false)

const sort = (field: string) => handleSort(field, params.value)

const save = () => {
    getDataForIndexPages(route('tenant.occasions.eid-suit.save-to-archive'), params.value, {
        onStart: () => {
            loading.value = true
        },
        onSuccess: () => {
            loading.value = false

            showWarningModalStatus.value = false

            setTimeout(() => {
                exportable.value = true
            }, 500)
        },
        preserveScroll: true,
        preserveState: true,
        only: ['orphans']
    })
}

const reset = () => {
    loadingReset.value = true

    router.patch(
        route('tenant.occasions.eid-suit.reset'),
        {},
        {
            onSuccess: () => {
                getDataForIndexPages(route('tenant.occasions.eid-suit.index'), params.value, {
                    preserveScroll: true,
                    preserveState: false,
                    only: ['orphans']
                })
            },
            onFinish: () => {
                nextTick(() => {
                    loadingReset.value = false

                    setTimeout(() => {
                        showWarningModalStatusForReset.value = false
                    }, 300)
                })
            }
        }
    )
}

const handleSave = () => {
    if (props.archive?.created_at) showWarningModalStatus.value = true
    else save()
}
</script>

<template>
    <Head :title="$t('the_orphans_eid_suit')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="eidSuitsFilters"
                :pagination-data="orphans"
                :params="params"
                :sortableFields="eidSuitSorts"
                :title="$t('list', { attribute: $t('the_orphans_eid_suit') })"
                :url="route('tenant.occasions.eid-suit.index')"
                entries="orphans"
                export-pdf-url="tenant.occasions.eid-suit.export.pdf"
                export-xlsx-url="tenant.occasions.eid-suit.export.xlsx"
                exportable
                filterable
                searchable
                sortable
                @change-filters="params.filters = $event"
            >
                <template #Hints>
                    <the-occasion-hint
                        v-if="false"
                        :on-hidden="
                            () => {
                                useSettingsStore().setHintToHidden('eid_suit')
                            }
                        "
                        hint-type="eid_suit"
                    ></the-occasion-hint>
                </template>

                <template #ExtraButtons>
                    <base-button
                        v-if="hasPermission('save_occasions')"
                        :disabled="loading"
                        class="me-2 shadow-md"
                        variant="primary"
                        @click.prevent="handleSave"
                    >
                        {{ $t('save') }}
                    </base-button>

                    <base-button
                        :disabled="loadingReset"
                        class="me-2 shadow-md"
                        variant="outline-danger"
                        @click.prevent="handleReset"
                    >
                        {{ $t('reset_eid_suit_data') }}
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="orphans.data.length > 0">
                <data-table :orphans :params @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="orphans"
                    :params
                    :url="route('tenant.occasions.eid-suit.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <the-warning-modal
                :on-progress="loading"
                :open="showWarningModalStatus"
                @accept="save"
                @close="showWarningModalStatus = false"
            >
                {{ $t('exports.archive.warnings.eid_suit') }}
            </the-warning-modal>

            <the-warning-modal
                :on-progress="loadingReset"
                :open="showWarningModalStatusForReset"
                @accept="reset"
                @close="showWarningModalStatusForReset = false"
            >
                {{ $t('reset_eid_suit_data') }}
            </the-warning-modal>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
