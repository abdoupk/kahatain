<script lang="ts" setup>
import type { IndexParams, NeedsIndexResource, PaginationData } from '@/types/types'

import NeedStatus from '@/Pages/Tenant/needs/index/NeedStatus.vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    needs: PaginationData<NeedsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="need in needs.data" :key="need.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ need.subject }}
                    </div>
                    <need-status :status="need.status" class="ms-auto"></need-status>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="truncate">{{ need.needable.name }}</p>
                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ $t(`needs.${need.needable.type}`) }}
                        </div>

                        <div class="w-fit">
                            <base-tippy :id="need.id" :content="need.readable_created_at">
                                <div
                                    class="mt-2 flex w-fit items-center rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                                >
                                    {{ formatDate(need.created_at, 'long') }}
                                </div>
                            </base-tippy>
                        </div>
                    </div>
                    <div class="flex w-1/4 items-center justify-end">
                        <a
                            v-if="hasPermission('view_needs')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="#"
                            @click.prevent="emit('showDetailsModal', need.id)"
                            >{{ $t('show') }}</a
                        >

                        <a
                            v-if="hasPermission('update_needs')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="#"
                            @click.prevent="emit('showEditModal', need.id)"
                            >{{ $t('edit') }}</a
                        >
                        <a
                            v-if="hasPermission('delete_needs')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click="emit('showDeleteModal', need.id)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
