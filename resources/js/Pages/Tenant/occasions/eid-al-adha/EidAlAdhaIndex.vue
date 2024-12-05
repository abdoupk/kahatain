<script lang="ts" setup>
import type { ArchiveOccasionType, EidAlAdhaFamiliesResource, IndexParams, PaginationData } from '@/types/types'

import { eidAlAdhaFilters } from '@/constants/filters'
import { useSettingsStore } from '@/stores/settings'
import { Head } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue'
import { defineAsyncComponent, ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { getDataForIndexPages, handleSort, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const DataTable = defineAsyncComponent(() => import('@/Pages/Tenant/occasions/eid-al-adha/DataTable.vue'))

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
    families: PaginationData<EidAlAdhaFamiliesResource>
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

const sort = (field: string) => handleSort(field, params.value)

const handleChangeStatus = (familyId: string, status: string) => {
    console.log(familyId, status)

    useForm('patch', route('tenant.occasions.eid-al-adha.change-status', familyId), {
        status
    }).submit({
        preserveScroll: true,
        preserveState: true
    })
}

const save = () => {
    getDataForIndexPages(route('tenant.occasions.eid-al-adha.save-to-archive'), params.value, {
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
</script>

<template>
    <Head :title="$t('the_families_eid_al_adha')"></Head>

    <suspense>
        <div>
            <the-table-header
                :exportable
                :filters="eidAlAdhaFilters"
                :pagination-data="families"
                :params="params"
                :title="$t('list', { attribute: $t('the_families_eid_al_adha') })"
                :url="route('tenant.occasions.eid-al-adha.index')"
                entries="families"
                export-pdf-url="tenant.occasions.eid-al-adha.export.pdf"
                export-xlsx-url="tenant.occasions.eid-al-adha.export.xlsx"
                filterable
                searchable
                @change-filters="params.filters = $event"
            >
                <template #Hints>
                    <the-occasion-hint
                        v-if="false"
                        :on-hidden="
                            () => {
                                useSettingsStore().setHintToHidden('eid_al_adha')
                            }
                        "
                        hint-type="eid_al_adha"
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
                </template>
            </the-table-header>

            <template v-if="families.data.length > 0">
                <data-table :families :params @sort="sort" @change-status="handleChangeStatus"></data-table>

                <the-table-footer
                    :pagination-data="families"
                    :params
                    :url="route('tenant.occasions.eid-al-adha.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>

            <the-warning-modal
                :on-progress="loading"
                :open="showWarningModalStatus"
                @accept="save"
                @close="showWarningModalStatus = false"
            >
                {{ $t('exports.archive.warnings.eid_al_adha') }}
            </the-warning-modal>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
