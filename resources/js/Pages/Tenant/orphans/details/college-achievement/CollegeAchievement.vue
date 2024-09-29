<script lang="ts" setup>
import type { OrphanShowType } from '@/types/orphans'

import DataTable from '@/Pages/Tenant/orphans/details/college-achievement/DataTable.vue'

import NoResultsFound from '@/Components/Global/NoResultsFound.vue'

defineProps<{
    orphan: OrphanShowType
}>()
</script>

<template>
    <!-- BEGIN: College Achievement -->
    <div class="intro-y col-span-12 overflow-x-auto">
        <data-table v-if="orphan.college_achievements.length > 0" :orphan></data-table>

        <div v-else class="flex flex-col items-center justify-center">
            <no-results-found>
                <template #default>
                    <p>{{ $t('No college achievement added yet.') }}</p>
                </template>
            </no-results-found>
        </div>
    </div>
    <!-- END: College Achievement -->
</template>
