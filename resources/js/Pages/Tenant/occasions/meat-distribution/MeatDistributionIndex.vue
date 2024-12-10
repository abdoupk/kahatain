<script lang="ts" setup>
import type { IndexParams, MeatDistributionFamiliesResource, PaginationData } from '@/types/types'

import { meatDistributionFilters } from '@/constants/filters'
import { useMeatDistributionStore } from '@/stores/meat-distribution'
import { useSettingsStore } from '@/stores/settings'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

import DataTable from '@/Pages/Tenant/occasions/meat-distribution/DataTable.vue'
import SaveToArchive from '@/Pages/Tenant/occasions/meat-distribution/SaveToArchive.vue'

import TheNoResultsTable from '@/Components/Global/DataTable/TheNoResultsTable.vue'
import TheTableFooter from '@/Components/Global/DataTable/TheTableFooter.vue'
import TheTableHeader from '@/Components/Global/DataTable/TheTableHeader.vue'
import TheOccasionHint from '@/Components/Global/TheOccasionHint.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'

import { handleSort, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    families: PaginationData<MeatDistributionFamiliesResource>
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

const sort = (field: string) => handleSort(field, params.value)
</script>

<template>
    <Head :title="$t('meat_distribution')"></Head>

    <suspense>
        <div>
            <the-table-header
                :filters="meatDistributionFilters"
                :pagination-data="families"
                :params="params"
                :title="$t('list', { attribute: $t('the_families') })"
                :url="route('tenant.occasions.meat-distribution.index')"
                entries="families"
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
                        v-if="
                            hasPermission('save_occasions') &&
                            useMeatDistributionStore().meatDistribution.families.length > 0
                        "
                        :params
                    ></save-to-archive>
                </template>
            </the-table-header>

            <template v-if="families.data.length > 0">
                <data-table :families :params @sort="sort"></data-table>

                <the-table-footer
                    :pagination-data="families"
                    :params
                    :url="route('tenant.occasions.meat-distribution.index')"
                ></the-table-footer>
            </template>

            <the-no-results-table v-else></the-no-results-table>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
