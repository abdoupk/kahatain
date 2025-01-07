<script lang="ts" setup>
import type { IndexParams, ListBoxFilter, PaginationData } from '@/types/types'

import { ref, watch } from 'vue'

import AdvancedFilter from '@/Pages/Tenant/families/index/AdvancedFilter.vue'

import BaseFormInput from '@/Components/Base/form/BaseFormInput.vue'
import ExportMenu from '@/Components/Global/ExportMenu.vue'
import TheMobileSorting from '@/Components/Global/TheMobileSorting.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { debounce, formatFilters, formatParams, getDataForIndexPages, isEmpty } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{
    url: string
    exportPdfUrl: string
    exportXlsxUrl: string
    entries: string
    title: string
    filters: ListBoxFilter[]
    paginationData: PaginationData<unknown>
    params: IndexParams
    exportable?: boolean
    filterable?: boolean
    searchable?: boolean
    sortable?: boolean
    sortableFields?: {
        label: string
        value: string
    }[]
    dontShowFilters?: boolean
}>()

const params = ref(props.params)

const search = ref(params.value.search)

const emit = defineEmits(['changeFilters'])

let routerOptions = {
    preserveState: true,
    preserveScroll: true
}

const exportPdfUrl = ref<string>(route(props.exportPdfUrl, params.value))

const exportXlsxUrl = ref<string>(route(props.exportXlsxUrl, params.value))

const getData = () => getDataForIndexPages(props.url, params.value, routerOptions)

const handleFilterReset = () => {
    params.value.filters = []

    handleExport(params.value)

    getData()
}

const handleFilter = (filters: IndexParams['filters']) => {
    if (!isEmpty(formatFilters(filters))) {
        params.value.filters = filters

        handleExport(params.value)

        emit('changeFilters', filters)

        getData()
    }
}

watch(
    () => search.value,
    debounce(() => {
        params.value.page = 1

        params.value.search = search.value

        getData()
    }, 400)
)

watch(() => [params.value.fields, params.value.directions], getData)

const handleExport = (params: IndexParams) => {
    if (props.exportable) {
        exportPdfUrl.value = route(props.exportPdfUrl, formatParams(params))

        exportXlsxUrl.value = route(props.exportXlsxUrl, formatParams(params))
    }
}

const handleSort = ({ field, direction }) => {
    params.value.fields = [field]

    params.value.directions = { [field]: direction }

    getData()
}
</script>

<template>
    <h2 class="intro-y mt-10 text-lg font-medium">
        {{ title }}
    </h2>

    <slot name="Hints"></slot>

    <div class="mt-5 grid grid-cols-12 gap-6 @container">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <slot name="ExtraButtons"></slot>

            <export-menu v-if="exportable" :exportPdfUrl :exportXlsxUrl :params></export-menu>

            <advanced-filter
                v-if="filterable"
                :filters
                class="ms-2 hidden @[33rem]:block"
                placement="bottom-start"
                @update:value="handleFilter"
                @reset-filter="handleFilterReset"
            ></advanced-filter>

            <the-mobile-sorting
                v-if="sortable"
                :sortable-fields
                class="ms-2 hidden @[33rem]:block @3xl:hidden"
                @sort="handleSort"
            ></the-mobile-sorting>

            <slot name="ExtraFilters"></slot>

            <div
                v-if="params.filters?.length && !dontShowFilters"
                class="ms-2 rounded-full bg-primary/20 px-2 py-1 text-primary dark:bg-darkmode-100/20 dark:text-slate-400"
            >
                <span> {{ $t('filters.active', { count: String(params.filters.length) }) }}</span>

                <svg-loader
                    class="ms-1 inline h-4 w-4 fill-slate-400 hover:cursor-pointer"
                    name="icon-x-mark"
                    @click.prevent="handleFilterReset"
                ></svg-loader>
            </div>

            <div class="me-2 ms-auto whitespace-nowrap text-center text-slate-500 md:mx-auto">
                <span v-if="paginationData.meta?.total > 0">
                    {{
                        $t('showing_results', {
                            from: paginationData.meta.from?.toString(),
                            to: paginationData.meta.to?.toString(),
                            total: paginationData.meta.total?.toString(),
                            entries: $tc(`entries.${entries}`, paginationData.meta.total)
                        })
                    }}
                </span>
            </div>

            <div class="mt-3 flex w-full sm:ms-auto sm:mt-0 sm:w-auto md:ms-0">
                <advanced-filter
                    v-if="filterable"
                    :filters
                    class="me-2 @[33rem]:hidden"
                    placement="bottom-start"
                    @update:value="handleFilter"
                    @reset-filter="handleFilterReset"
                ></advanced-filter>

                <the-mobile-sorting
                    v-if="sortable"
                    :sortable-fields
                    class="@[33rem]:hidden"
                    @sort="handleSort"
                ></the-mobile-sorting>

                <div v-if="searchable" class="relative w-full text-slate-500 md:w-56">
                    <base-form-input
                        v-model="search"
                        :placeholder="$t('Search...')"
                        autofocus
                        class="!box w-full pe-10 md:w-56"
                        type="text"
                    />

                    <svg-loader class="absolute inset-y-0 end-0 my-auto me-3 h-4 w-4" name="icon-search" />
                </div>
            </div>
        </div>
    </div>
</template>
