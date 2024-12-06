<script lang="ts" setup>
import { router } from '@inertiajs/vue3'

import PaginationDataTable from '@/Components/Global/PaginationDataTable.vue'

defineProps<{
    needs: any
    archivesMeta: any
    familyId: string
}>()
</script>

<template>
    <h1 v-for="need in needs.data" :key="need.id">
        {{ need.subject }}
    </h1>

    <pagination-data-table
        :page="needs.meta.current_page"
        :pages="needs.meta.last_page"
        :per-page="needs.meta.per_page"
        @change-page="
            ($e) => {
                router.get(
                    route('tenant.families.history', {
                        family: familyId,
                        needs_page: $e,
                        needs_perPage: needs.meta.per_page,
                        archives_page: archivesMeta.current_page,
                        archives_perPage: archivesMeta.per_page
                    }),
                    {},
                    { only: ['needs'], preserveState: true, preserveScroll: true }
                )
            }
        "
    ></pagination-data-table>
</template>
