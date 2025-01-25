<script lang="ts" setup>
import type { IndexParams, OrphansTranscriptsIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import TranscriptActions from '@/Pages/Tenant/transcripts/create/TranscriptActions.vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
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
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        <Link v-if="hasPermission('view_orphans')" :href="route('tenant.orphans.show', orphan.id)">
                            {{ orphan.name }}
                        </Link>

                        <span v-else>
                            {{ orphan.name }}
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('the_sponsor') }}
                        </div>
                        {{ orphan.sponsor.name }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('sponsor_phone_number') }}
                        </div>
                        {{ orphan.sponsor.phone_number }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.institution') }}
                        </div>
                        {{ orphan.institution?.name || '————' }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('general_average') }}
                        </div>
                        {{ orphan.academic_average ? parseFloat(orphan.academic_average).toFixed(2) : '————' }}
                    </div>

                    <div class="my-3 -ms-3 flex items-center justify-start">
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

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('academic_level')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ orphan.academic_level.level }} ({{ orphan.academic_level.phase }})
                        </base-tippy>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
