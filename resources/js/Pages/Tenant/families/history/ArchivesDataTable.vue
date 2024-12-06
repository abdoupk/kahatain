<script lang="ts" setup>
import { router } from '@inertiajs/vue3'

import PaginationDataTable from '@/Components/Global/PaginationDataTable.vue'

defineProps<{
    archives: any
    needsMeta: any
    familyId: string
}>()
</script>

<template>
    <h1 v-for="archive in archives.data" :key="archive.id">
        {{ archive.occasion }}
    </h1>

    <pagination-data-table
        :page="archives.meta.current_page"
        :pages="archives.meta.last_page"
        :per-page="archives.meta.per_page"
        @change-page="
            ($e) => {
                router.get(
                    route('tenant.families.show', familyId),
                    {
                        archives_page: $e,
                        needs_page: needsMeta.current_page,
                        needs_perPage: needsMeta.per_page,
                        archives_perPage: archives.meta.per_page
                    },
                    { only: ['archives'], preserveScroll: true, preserveState: true }
                )
            }
        "
    ></pagination-data-table>
</template>
