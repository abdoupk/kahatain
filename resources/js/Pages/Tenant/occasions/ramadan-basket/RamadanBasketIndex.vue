<script lang="ts" setup>
import type { ArchiveOccasionType, IndexParams, PaginationData, RamadanBasketFamiliesResource } from '@/types/types'

import { ramadanBasketFilters } from '@/constants/filters'
import { ramadanBasketSorts } from '@/constants/sorts'
import { useSettingsStore } from '@/stores/settings'
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheSettingsModal from '@/Pages/Tenant/occasions/ramadan-basket/settings/TheSettingsModal.vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/occasions/ramadan-basket/DataTable.vue'))

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const TheTableFooter = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableFooter.vue'))

const TheTableHeader = defineAsyncComponent(() => import('@/Components/Global/DataTable/TheTableHeader.vue'))

const NoResultsFound = defineAsyncComponent(() => import('@/Components/Global/NoResultsFound.vue'))

const TheOccasionHint = defineAsyncComponent(() => import('@/Components/Global/TheOccasionHint.vue'))

const TheWarningModal = defineAsyncComponent(() => import('@/Components/Global/TheWarningModal.vue'))

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    families: PaginationData<RamadanBasketFamiliesResource>
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

const showWarningModalStatus = ref(false)

const showSettingsModalStatus = ref(false)

const sponsorshipsStore = useSponsorshipsStore()

const sort = (field: string) => handleSort(field, params.value)

const save = () => {
    getDataForIndexPages(route('tenant.occasions.ramadan-basket.save-to-archive'), params.value, {
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
        only: ['families']
    })
}

const handleSave = () => {
    if (props.archive?.created_at) showWarningModalStatus.value = true
    else save()
}

const showSettingsModal = () => {
    sponsorshipsStore.$reset()

    sponsorshipsStore.getRamadanSponsorshipSettings()

    showSettingsModalStatus.value = true
}
</script>

<template>
    <Head :title="$t('the_families_ramadan_basket')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable
                :filters="ramadanBasketFilters"
                :pagination-data="families"
                :params="params"
                :sortableFields="ramadanBasketSorts"
                :title="$t('list', { attribute: $t('the_families_ramadan_basket') })"
                :url="route('tenant.occasions.ramadan-basket.index')"
                entries="families"
                export-pdf-url="tenant.occasions.ramadan-basket.export.pdf"
                export-xlsx-url="tenant.occasions.ramadan-basket.export.xlsx"
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
                                useSettingsStore().setHintToHidden('ramadan_basket')
                            }
                        "
                        hint-type="ramadan_basket"
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

                    <base-button class="me-2" @click.prevent="showSettingsModal">
                        <base-tippy :content="$t('settings')">
                            <svg-loader name="icon-gear"></svg-loader>
                        </base-tippy>
                    </base-button>
                </template>
            </the-table-header>

            <template v-if="families.data.length > 0">
                <data-table :families :params @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="families"
                    :params
                    class="mt-4"
                    :url="route('tenant.occasions.ramadan-basket.index')"
                ></the-table-footer>
            </template>

            <div v-else class="intro-x mt-12 flex flex-col items-center justify-center">
                <no-results-found></no-results-found>
            </div>

            <the-warning-modal
                :on-progress="loading"
                :open="showWarningModalStatus"
                @accept="save"
                @close="showWarningModalStatus = false"
            >
                {{ $t('exports.archive.warnings.ramadan_basket') }}
            </the-warning-modal>

            <the-settings-modal
                :open="showSettingsModalStatus"
                @close="showSettingsModalStatus = false"
            ></the-settings-modal>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
