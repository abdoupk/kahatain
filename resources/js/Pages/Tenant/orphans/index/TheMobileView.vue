<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t, getLocale } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<OrphansIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])

const familyStatusFilter = computed(() => {
    return `family_status.${getLocale()}`
})
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
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
                        <p class="line-clamp-2 font-medium">{{ orphan.note }}</p>
                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(orphan.birth_date, 'long') }}
                        </div>
                    </div>
                    <div class="flex w-1/4 items-center justify-end">
                        <Link
                            v-if="hasPermission('edit_orphans')"
                            :href="route('tenant.orphans.edit', orphan.id)"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            >{{ $t('edit') }}
                        </Link>
                        <a
                            v-if="hasPermission('delete_orphans')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click="emit('showDeleteModal', orphan.id)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
