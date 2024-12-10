<script lang="ts" setup>
import type { IndexParams, PaginationData, ZonesIndexResource } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    zones: PaginationData<ZonesIndexResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="zone in zones.data" :key="zone.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ zone.name }}
                    </div>

                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        <base-tippy :content="$t('families_count')">
                            {{ zone.families_count }}
                        </base-tippy>
                    </div>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="truncate">
                            {{ zone.description }}
                        </p>

                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ zone.created_at }}
                        </div>
                    </div>
                    <div class="flex w-1/4 items-center justify-end">
                        <a
                            v-if="hasPermission('view_zones')"
                            class="me-2 flex items-center"
                            href="javascript:void(0)"
                            @click="emit('showDetailsModal', zone.id)"
                        >
                            {{ $t('show') }}
                        </a>
                        <a
                            v-if="hasPermission('update_zones')"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            href="javascript:void(0)"
                            @click="emit('showEditModal', zone.id)"
                            >{{ $t('edit') }}
                        </a>
                        <a
                            v-if="hasPermission('delete_zones')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click="emit('showDeleteModal', zone.id)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
