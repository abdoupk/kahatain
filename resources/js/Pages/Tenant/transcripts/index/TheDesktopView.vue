<script lang="ts" setup>
import type { IndexParams, OrphansTranscriptsIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

import TranscriptActions from '@/Pages/Tenant/transcripts/create/TranscriptActions.vue'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<OrphansTranscriptsIndexResource>
    params: IndexParams
    shouldCreateFirstTrimesterTranscript: boolean
    shouldCreateSecondTrimesterTranscript: boolean
    shouldCreateThirdTrimesterTranscript: boolean
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showCreateModal', 'showDeleteModal', 'showEditModal'])

const showSuccessNotification = ref(false)

const handleShowSuccessNotification = () => {
    showSuccessNotification.value = true

    setTimeout(() => {
        showSuccessNotification.value = false
    }, 500)
}
</script>

<template>
    <div class="intro-y !z-30 col-span-12 hidden overflow-x-auto overflow-y-hidden @3xl:block">
        <base-table class="mt-2 border-separate border-spacing-y-[10px]">
            <base-thead-table>
                <base-tr-table>
                    <the-table-th class="text-start"> #</the-table-th>

                    <the-table-th
                        :direction="params.directions?.name"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'name')"
                    >
                        {{ $t('the_child') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['academic_level.i_id']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'academic_level.i_id')"
                        >{{ $t('validation.attributes.sponsor.academic_level') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['academic_average']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'academic_average')"
                        >{{ $t('general_average') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['institution.name']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'institution.name')"
                        >{{ $t('validation.attributes.institution') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.birth_date"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'birth_date')"
                        >{{ $t('validation.attributes.date_of_birth') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['sponsor.name']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'sponsor.name')"
                        >{{ $t('the_sponsor') }}
                    </the-table-th>

                    <the-table-th class="text-center">{{ $t('sponsor_phone_number') }}</the-table-th>

                    <the-table-th v-if="hasPermission(['update_orphans'])" class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(orphan, index) in orphans.data" :key="orphan.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (orphans.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link
                            v-if="hasPermission('view_orphans')"
                            :href="route('tenant.orphans.show', orphan.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ orphan.name }}
                        </Link>

                        <span v-else> {{ orphan.name }}</span>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <base-tippy :content="orphan.academic_level.level">
                            {{ orphan.academic_level.level }}
                        </base-tippy>

                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ orphan.academic_level.phase }}
                        </div>
                    </the-table-td>

                    <the-table-td class="max-w-20 truncate text-center">
                        <span v-if="orphan.academic_average">
                            {{ orphan.academic_average.toFixed(2) }}
                        </span>

                        <span v-else> ————</span>
                    </the-table-td>

                    <the-table-td class="max-w-20 truncate text-center">
                        {{ orphan.institution?.name || '————' }}
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ formatDate(orphan.birth_date, 'long') }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <Link
                            v-if="hasPermission('view_sponsors')"
                            :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ orphan.sponsor.name }}
                        </Link>

                        <span v-else class="font-medium rtl:!font-semibold">{{ orphan.sponsor.name }}</span>
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ orphan.sponsor?.phone_number }}
                    </the-table-td>

                    <the-table-td-actions v-if="hasPermission(['update_orphans'])">
                        <div class="flex items-center justify-center">
                            <transcript-actions
                                :orphan
                                :shouldCreateFirstTrimesterTranscript
                                :shouldCreateSecondTrimesterTranscript
                                :shouldCreateThirdTrimesterTranscript
                                @show-success-notification="handleShowSuccessNotification"
                                @show-create-modal="emit('showCreateModal', $event)"
                                @show-edit-modal="emit('showEditModal', $event)"
                                @show-delete-modal="emit('showDeleteModal', $event)"
                            ></transcript-actions>
                        </div>
                    </the-table-td-actions>
                </base-tr-table>
            </base-tbody-table>
        </base-table>
    </div>

    <success-notification :open="showSuccessNotification" :title="$t('successfully_updated')"></success-notification>
</template>
