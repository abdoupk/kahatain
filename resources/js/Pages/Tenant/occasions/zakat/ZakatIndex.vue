<script lang="ts" setup>
import type { ArchiveOccasionType, IndexParams, PaginationData, ZakatFamiliesResource } from '@/types/types'

import { zakatFilters } from '@/constants/filters'
import { useSettingsStore } from '@/stores/settings'
import { useZakatStore } from '@/stores/zakat'
import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import SaveToArchive from '@/Pages/Tenant/occasions/zakat/SaveToArchive.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/occasions/zakat/DataTable.vue'))

const TheNoResultsTable = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheNoResultsTable.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const TheOccasionHint = defineAsyncComponent(() => import('@/Components/Global/TheOccasionHint.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    families: PaginationData<ZakatFamiliesResource>
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

const sort = (field: string) => handleSort(field, params.value)
</script>

<template>
    <Head :title="$t('zakat')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="zakatFilters"
                :pagination-data="families"
                :params="params"
                :title="$t('list', { attribute: $t('the_families') })"
                :url="route('tenant.occasions.zakat.index')"
                entries="families"
                export-pdf-url="tenant.occasions.zakat.export.pdf"
                export-xlsx-url="tenant.occasions.zakat.export.xlsx"
                exportable
                filterable
                searchable
                @change-filters="params.filters = $event"
            >
                <template #Hints>
                    <the-occasion-hint
                        v-if="false"
                        :on-hidden="
                            () => {
                                useSettingsStore().setHintToHidden('zakat')
                            }
                        "
                        hint-type="zakat"
                    ></the-occasion-hint>
                </template>

                <template #ExtraButtons>
                    <save-to-archive
                        v-if="hasPermission('save_occasions') && useZakatStore().zakat.families.length > 0"
                        :params
                    ></save-to-archive>
                </template>
            </the-table-header>

            <template v-if="families.data.length > 0">
                <data-table :families :params @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="families"
                    :params
                    :url="route('tenant.occasions.zakat.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
