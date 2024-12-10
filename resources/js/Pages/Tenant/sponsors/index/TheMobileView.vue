<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="sponsor in sponsors.data" :key="sponsor.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        <Link
                            v-if="hasPermission('view_sponsors')"
                            :href="route('tenant.sponsors.show', sponsor.id)"
                            class="font-medium rtl:font-semibold"
                        >
                            {{ sponsor.name }}
                        </Link>

                        <span v-else class="font-medium rtl:font-semibold">{{ sponsor.name }}</span>
                    </div>
                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ $t(`sponsor_types.${sponsor.sponsor_type}`) }}
                    </div>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="truncate">{{ sponsor.health_status }}</p>

                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ sponsor.function }}
                        </div>
                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ sponsor.phone_number }}
                        </div>
                    </div>
                    <div class="flex w-1/4 items-center justify-end">
                        <Link
                            v-if="hasPermission('update_sponsors')"
                            :href="route('tenant.sponsors.show', sponsor.id)"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            >{{ $t('edit') }}
                        </Link>

                        <a
                            v-if="hasPermission('delete_sponsors')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click="emit('showDeleteModal', sponsor.id)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
