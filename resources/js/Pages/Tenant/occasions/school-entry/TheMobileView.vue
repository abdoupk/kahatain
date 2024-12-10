<script lang="ts" setup>
import type { IndexParams, PaginationData, SchoolEntryOrphansResource } from '@/types/types'

defineProps<{
    orphans: PaginationData<SchoolEntryOrphansResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ orphan.orphan.name }}
                    </div>
                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ orphan.orphan.last_year_average }}
                    </div>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="truncate">
                            {{ orphan.sponsor.name }}

                            <span v-if="orphan.sponsor.phone_number" dir="ltr"
                                >({{ orphan.sponsor.phone_number }})</span
                            >
                        </p>

                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ orphan.family.address }}
                        </div>
                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ orphan.orphan.academic_level }} ({{ orphan.orphan.academic_phase }})
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
