<script lang="ts" setup>
import type { CommitteesIndexResource, IndexParams, PaginationData } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    committees: PaginationData<CommitteesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="committee in committees.data" :key="committee.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ committee.name }}
                    </div>

                    <base-tippy
                        :content="$t('members_count')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ committee.members_count }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <p>{{ committee.description }}</p>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('added_at')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ committee.created_at }}
                        </base-tippy>

                        <div class="ms-auto flex items-center justify-end">
                            <a
                                v-if="hasPermission('view_committees')"
                                class="me-2 text-slate-500 dark:text-slate-400 rtl:font-semibold"
                                href="javascript:void(0)"
                                @click="emit('showDetailsModal', committee.id)"
                                >{{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_committees')"
                                class="me-2 text-slate-500 dark:text-slate-400 rtl:font-semibold"
                                href="javascript:void(0)"
                                @click="emit('showEditModal', committee.id)"
                                >{{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission('delete_committees')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', committee.id)"
                            >
                                {{ $t('delete') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
