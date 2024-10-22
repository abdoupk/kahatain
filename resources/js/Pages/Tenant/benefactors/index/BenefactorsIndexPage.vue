<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { ref } from 'vue'

import TheLayout from '@/Layouts/TheLayout.vue'

defineOptions({
    layout: TheLayout
})

const props = defineProps<{
    benefactors: PaginationData<FamiliesIndexResource>
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
</script>

<template>
    <pre>
        {{ benefactors }}
    </pre>
</template>
