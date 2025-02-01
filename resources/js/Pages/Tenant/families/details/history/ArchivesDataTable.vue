<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import NoResultsFound from '@/Components/Global/NoResultsFound.vue'
import PaginationDataTable from '@/Components/Global/PaginationDataTable.vue'

import { formatCurrency, formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    archives: PaginationData<unknown>
    needsMeta: PaginationData['meta']
    familyId: string
}>()

function fetchArchives(data: object) {
    const newPerPage = data.archives_perPage || props.archives.meta.per_page

    const totalItems = props.archives.meta.total

    const totalPages = Math.ceil(totalItems / newPerPage)

    // Check if the current page exceeds the total pages
    if (props.archives.meta.current_page > totalPages) {
        // Reset current page to the last available page
        data.archives_page = totalPages
    }

    let routerData = {
        archives_page: props.archives.meta.current_page,
        archives_perPage: props.archives.meta.per_page,
        needs_page: props.needsMeta.current_page,
        needs_perPage: props.needsMeta.per_page
    }

    routerData = { ...routerData, ...data }

    router.get(route('tenant.families.show', props.familyId), routerData, {
        only: ['archives'],
        preserveState: true,
        preserveScroll: true
    })
}
</script>

<template>
    <div class="intro-y">
        <h3 class="text-base font-medium rtl:!font-semibold">
            {{ $t('benefit_archive') }}
        </h3>

        <div v-if="archives.data" class="mt-2 overflow-y-hidden">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-center"> #</the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('recipient_type') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('the_benefit_type') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('the_benefit_date') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(archive, index) in archives.data" :key="archive.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (archives.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            <Link
                                v-if="hasPermission('view_orphans') && archive.archiveable_type === 'orphan'"
                                :href="route('tenant.orphans.show', archive.recipient_id)"
                            >
                                {{ $t(`the_${archive.pivot.archiveable_type}`) }}
                                <template v-if="archive?.recipient_name"> ({{ archive.recipient_name }})</template>
                            </Link>

                            <span v-else> {{ $t(`the_${archive.pivot.archiveable_type}`) }}</span>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ $t(`occasions.${archive.occasion}`) }}

                            <template v-if="archive.metadata">
                                ({{ formatCurrency(archive.metadata.amount) }})
                            </template>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ formatDate(archive.created_at, 'full') }}
                        </the-table-td>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <div
            v-else
            class="intro-x col-span-12 mt-8 flex flex-col items-center justify-center @container 2xl:col-span-6"
        >
            <no-results-found></no-results-found>
        </div>

        <pagination-data-table
            v-if="archives.data"
            :page="archives.meta.current_page"
            :pages="archives.meta.last_page"
            :per-page="archives.meta.per_page"
            @update:per-page="fetchArchives({ archives_perPage: $event })"
            @change-page="fetchArchives({ archives_page: $event })"
        ></pagination-data-table>
    </div>
</template>
