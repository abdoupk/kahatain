<script lang="ts" setup>
import type { IndexParams, PaginationData } from '@/types/types'

import { ref } from 'vue'

import PaginationDataTable from '@/Components/Global/PaginationDataTable.vue'

import { getDataForIndexPages } from '@/utils/helper'

const props = defineProps<{
    paginationData: PaginationData<unknown>
    params: IndexParams
    url: string
}>()

const params = ref(props.params)

const getData = () =>
    getDataForIndexPages(props.url, params.value, {
        preserveState: false,
        preserveScroll: false
    })

const handleChangePerPage = (value: number) => {
    params.value.perPage = value

    params.value.page = 1

    getData()
}

const handleChangePage = (value: number) => {
    params.value.page = value

    getData()
}
</script>

<template>
    <pagination-data-table
        v-model:page="params.page"
        v-model:per-page="params.perPage"
        :pages="paginationData.meta.last_page"
        @update:per-page="handleChangePerPage"
        @change-page="handleChangePage"
    ></pagination-data-table>
</template>
