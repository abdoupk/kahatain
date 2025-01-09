<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<OrphansIndexResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <Link :href="route('tenant.orphans.show', orphan.id)" class="me-3 truncate text-lg font-medium">
                        {{ orphan.name }}
                    </Link>

                    <base-tippy
                        v-if="orphan.family_status"
                        :content="$t('family_status')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ $t(`family_statuses.${orphan.family_status}`) }}
                    </base-tippy>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="line-clamp-2 font-medium">{{ orphan.note }}</p>
                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(orphan.birth_date, 'long') }}
                        </div>
                    </div>
                    <div class="flex w-1/4 items-center justify-end">
                        <Link
                            v-if="hasPermission('view_orphans')"
                            :href="route('tenant.orphans.show', orphan.id)"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            >{{ $t('show') }}
                        </Link>

                        <Link
                            v-if="hasPermission('edit_orphans')"
                            :href="route('tenant.orphans.edit', orphan.id)"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            >{{ $t('edit') }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
