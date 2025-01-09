<script lang="ts" setup>
import type { IndexParams, MembersIndexResource, PaginationData } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    members: PaginationData<MembersIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="member in members.data" :key="member.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ member.name }}
                    </div>
                    <base-tippy
                        :content="$t('validation.attributes.phone_number')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ member.phone }}
                    </base-tippy>
                </div>

                <div class="mt-4 flex">
                    <div class="w-3/4">
                        <p class="truncate">{{ member.email }}</p>

                        <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ member.zone?.name }}
                        </div>
                        <base-tippy
                            :content="$t('added_at')"
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(member.created_at, 'long') }}
                        </base-tippy>
                    </div>

                    <div class="flex w-1/4 items-center justify-end">
                        <a
                            v-if="hasPermission('view_members')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="javascript:void(0)"
                            @click.prevent="emit('showDetailsModal', member.id)"
                            >{{ $t('show') }}
                        </a>

                        <a
                            v-if="hasPermission('update_members')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="javascript:void(0)"
                            @click.prevent="emit('showEditModal', member.id)"
                            >{{ $t('edit') }}
                        </a>

                        <a
                            v-if="hasPermission('delete_members')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click="emit('showDeleteModal', member.id)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
