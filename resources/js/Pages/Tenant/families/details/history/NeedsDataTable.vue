<script lang="ts" setup>
import { type PaginationData } from '@/types/types'

import { router } from '@inertiajs/vue3'

import NeedStatus from '@/Pages/Tenant/needs/index/NeedStatus.vue'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import NoResultsFound from '@/Components/Global/NoResultsFound.vue'
import PaginationDataTable from '@/Components/Global/PaginationDataTable.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

const props = defineProps<{
    needs: PaginationData<unknown>
    archivesMeta: PaginationData['meta']
    familyId: string
}>()

function fetchNeeds(data: object) {
    const newPerPage = data.needs_perPage || props.needs.meta.per_page

    const totalItems = props.needs.meta.total

    const totalPages = Math.ceil(totalItems / newPerPage)

    // Check if the current page exceeds the total pages
    if (props.needs.meta.current_page > totalPages) {
        // Reset current page to the last available page
        data.needs_page = totalPages
    }

    let routerData = {
        needs_page: props.needs.meta.current_page,
        needs_perPage: props.needs.meta.per_page,
        archives_page: props.archivesMeta.current_page,
        archives_perPage: props.archivesMeta.per_page
    }

    routerData = { ...routerData, ...data }

    router.get(route('tenant.families.show', props.familyId), routerData, {
        only: ['needs'],
        preserveState: true,
        preserveScroll: true
    })
}
</script>

<template>
    <div class="intro-y">
        <h3 class="mt-8 text-base font-medium rtl:!font-semibold">
            {{ $t('benefit_needs') }}
        </h3>

        <div v-if="Object.keys(needs.data).length > 0" class="mt-2 overflow-y-hidden">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th class="text-start">
                            {{ $t('the_requester') }}
                        </the-table-th>

                        <the-table-th class="text-start">{{ $t('validation.attributes.subject') }}</the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('the_demand') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('validation.attributes.the_status') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('validation.attributes.note') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(need, index) in needs.data" :key="need.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ Number(index) + 1 }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            {{ $t(`the_${need.needable_type}`) }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            {{ need.subject }}
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            <base-tippy :content="need.demand">
                                <svg-loader class="mx-auto block h-6 w-6" name="icon-file-lines"></svg-loader>
                            </base-tippy>
                        </the-table-td>

                        <the-table-td class="w-30 text-center">
                            <need-status :status="need.status"></need-status>
                        </the-table-td>

                        <the-table-td class="w-40">
                            <base-tippy v-if="need.note" :content="need.note">
                                <svg-loader class="mx-auto block" name="icon-note"></svg-loader>
                            </base-tippy>

                            <span v-else class="mx-auto block text-center">————</span>
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
    </div>

    <pagination-data-table
        v-if="Object.keys(needs.data).length > 0"
        :page="needs.meta.current_page"
        :pages="needs.meta.last_page"
        :per-page="needs.meta.per_page"
        @update:per-page="fetchNeeds({ needs_perPage: $event })"
        @change-page="fetchNeeds({ needs_page: $event })"
    ></pagination-data-table>
</template>
