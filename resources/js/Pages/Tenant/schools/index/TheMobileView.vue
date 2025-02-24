<script lang="ts" setup>
import type { IndexParams, PaginationData, SchoolsIndexResource } from '@/types/types'

import { route } from 'ziggy-js'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    schools: PaginationData<SchoolsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="school in schools.data" :key="school.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ school.name }}
                    </div>
                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        <base-tippy :content="$t('quota_total')">
                            {{ school.quota }}
                        </base-tippy>
                    </div>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(school.created_at, 'full') }}
                        </div>
                    </div>
                    <div class="flex w-1/4 items-center justify-end">
                        <a
                            v-if="hasPermission('print_schools')"
                            :class="{ 'pointer-events-none opacity-50': !school.should_print }"
                            :href="route('tenant.schools.export.pdf', school.id)"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                        >
                            {{ $t('print') }}
                        </a>

                        <a
                            v-if="hasPermission('view_schools')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="javascript:void(0)"
                            @click.prevent="emit('showDetailsModal', school.id)"
                        >
                            {{ $t('show') }}
                        </a>

                        <a
                            v-if="hasPermission('update_schools')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="javascript:void(0)"
                            @click.prevent="emit('showEditModal', school.id)"
                            >{{ $t('edit') }}
                        </a>

                        <a
                            v-if="hasPermission('delete_schools')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click="emit('showDeleteModal', school.id)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
