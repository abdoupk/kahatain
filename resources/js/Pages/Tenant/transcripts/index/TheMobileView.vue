<script lang="ts" setup>
import type { IndexParams, OrphansTranscriptsIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'
import dayjs from 'dayjs'
import { computed } from 'vue'

import TranscriptActions from '@/Pages/Tenant/transcripts/create/TranscriptActions.vue'

import { formatDate } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<OrphansTranscriptsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showCreateModal', 'showDeleteModal', 'showEditModal'])

const now = dayjs()

const shouldCreateFirstTrimesterTranscript = computed(() => {
    const isFebToAug = now.month() >= 1 && now.month() <= 7

    const isNovOrDecPrevYear = now.month() === 10 || now.month() === 11

    return isNovOrDecPrevYear || isFebToAug
})

const shouldCreateSecondTrimesterTranscript = computed(() => {
    return now.month() >= 1 && now.month() <= 7
})

const shouldCreateThirdTrimesterTranscript = computed(() => {
    return now.month() >= 4 && now.month() <= 7
})
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div
            v-for="(orphan, index) in orphans.data"
            :key="orphan.id"
            :style="{ zIndex: orphans.data.length - index }"
            class="intro-y col-span-12 @xl:col-span-6"
        >
            <div class="box p-5">
                <div class="flex">
                    <Link :href="route('tenant.orphans.show', orphan.id)" class="me-3 truncate text-lg font-medium">
                        {{ orphan.name }}
                    </Link>
                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ $t(`family_statuses.${orphan.family_status}`) }}
                    </div>
                </div>

                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="line-clamp-2 font-medium">
                            {{ orphan.note }}
                        </p>

                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(orphan.birth_date, 'long') }}
                        </div>
                    </div>

                    <div class="flex w-1/4 items-center justify-end">
                        <transcript-actions
                            :orphan
                            :shouldCreateFirstTrimesterTranscript
                            :shouldCreateSecondTrimesterTranscript
                            :shouldCreateThirdTrimesterTranscript
                            @show-create-modal="emit('showCreateModal', $event)"
                            @show-edit-modal="emit('showEditModal', $event)"
                            @show-delete-modal="emit('showDeleteModal', $event)"
                        ></transcript-actions>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
