<script lang="ts" setup>
import type {
    ArchiveOccasionType,
    IndexParams,
    MonthlySponsorshipFamiliesResource,
    PaginationData
} from '@/types/types'

import { monthlySponsorshipFilters } from '@/constants/filters'
import { monthlySponsorshipSorts } from '@/constants/sorts'
import { useSettingsStore } from '@/stores/settings'
import { useSponsorshipsStore } from '@/stores/sponsorships'
import { Head } from '@inertiajs/vue3'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const TheSettingsModal = defineAsyncComponent(
    () => import('@/Pages/Tenant/occasions/monthly-sponsorship/settings/TheSettingsModal.vue')
)

const BaseTippy = defineAsyncComponent(() => import('@/Components/Base/tippy/BaseTippy.vue'))

const TheContentLoader = defineAsyncComponent(() => import('@/Components/Global/theContentLoader.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/occasions/monthly-sponsorship/DataTable.vue'))

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
    families: PaginationData<MonthlySponsorshipFamiliesResource>
    params: IndexParams
    archive: ArchiveOccasionType
    settings: object
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

sponsorshipsStore.monthly_sponsorship = props.settings

const sort = (field: string) => handleSort(field, params.value)

const save = () => {
    getDataForIndexPages(route('tenant.occasions.monthly-sponsorship.save-to-archive'), params.value, {
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

sponsorshipsStore.monthly_sponsorship = props.settings

const showSettingsModal = () => {
    sponsorshipsStore.$reset()

    sponsorshipsStore.getMonthlySponsorshipSettings()

    sponsorshipsStore.getMonthlyBasketItems(1)

    showSettingsModalStatus.value = true
}
</script>

<template>
    <Head :title="$t('the_families_monthly_basket')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable
                :filters="monthlySponsorshipFilters"
                :pagination-data="families"
                :params="params"
                :sortableFields="monthlySponsorshipSorts"
                :title="$t('list', { attribute: $t('the_families_monthly_basket') })"
                :url="route('tenant.occasions.monthly-sponsorship.index')"
                entries="families"
                export-pdf-url="tenant.occasions.monthly-sponsorship.export.pdf"
                export-xlsx-url="tenant.occasions.monthly-sponsorship.export.xlsx"
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
                                useSettingsStore().setHintToHidden('monthly_basket')
                            }
                        "
                        hint-type="monthly_basket"
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
                        v-if="hasPermission(['update_settings', 'update_monthly_basket'])"
                        class="me-2"
                        @click.prevent="showSettingsModal"
                    >
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
                    :url="route('tenant.occasions.monthly-sponsorship.index')"
                    class="mt-2"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <the-warning-modal
                :on-progress="loading"
                :open="showWarningModalStatus"
                @accept="save"
                @close="showWarningModalStatus = false"
            >
                {{ $t('exports.archive.warnings.monthly_basket') }}
            </the-warning-modal>

            <the-settings-modal :open="showSettingsModalStatus" @close="showSettingsModalStatus = false">
            </the-settings-modal>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
