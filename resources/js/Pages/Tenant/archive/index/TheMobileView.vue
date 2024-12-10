<script lang="ts" setup>
import type { ArchiveIndexResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    items: PaginationData<ArchiveIndexResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="item in items.data" :key="item.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        <Link :href="item.url">{{ item.name }}</Link>
                    </div>
                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        <base-tippy :content="$t('archive.families_count')">
                            {{ item.families_count }}
                        </base-tippy>
                    </div>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <Link
                            :href="route('tenant.members.index') + `?show=${item.savedBy.id}`"
                            class="truncate font-medium"
                        >
                            {{ item.savedBy.name }}
                        </Link>

                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ item.readable_created_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
