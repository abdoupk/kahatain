<script lang="ts" setup>
import type { IndexParams, OrphansIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, formatDate, hasPermission } from '@/utils/helper'
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
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ orphan.name }}
                    </div>

                    <base-tippy
                        v-if="orphan.family_status"
                        :content="$t('family_status')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ $t(`family_statuses.${orphan.family_status}`) }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('academic_level') }}
                        </div>
                        {{ orphan.academic_level }} ({{ orphan.academic_level_phase }})
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('income_rate') }}
                        </div>
                        {{ formatCurrency(orphan.income_rate) }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.sponsor.health_status') }}
                        </div>
                        {{ orphan.health_status }}
                    </div>

                    <template v-if="orphan.age > 2">
                        <div class="mt-2 flex">
                            <div class="w-28 rtl:!font-semibold">
                                {{ $t('shirt_size') }}
                            </div>
                            {{ orphan.shirt_size }}
                        </div>

                        <div class="mt-2 flex">
                            <div class="w-28 rtl:!font-semibold">
                                {{ $t('shoes_size') }}
                            </div>
                            {{ orphan.shoes_size }}
                        </div>

                        <div class="mt-2 flex">
                            <div class="w-28 rtl:!font-semibold">
                                {{ $t('pants_size') }}
                            </div>
                            {{ orphan.pants_size }}
                        </div>
                    </template>

                    <template v-else>
                        <div class="mt-2 flex">
                            <div class="w-28 rtl:!font-semibold">
                                {{ $t('filters.diapers_type') }}
                            </div>
                            {{ orphan.baby_diapers_type }} ({{ orphan.baby_diapers_quantity }})
                        </div>

                        <div class="mt-2 flex">
                            <div class="w-28 rtl:!font-semibold">
                                {{ $t('filters.baby_milk_type') }}
                            </div>
                            {{ orphan.baby_milk_type }} ({{ orphan.baby_milk_quantity }})
                        </div>
                    </template>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('filters.birth_date')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(orphan.birth_date, 'full') }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <Link
                                v-if="hasPermission('view_orphans')"
                                :href="route('tenant.orphans.show', orphan.id)"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                >{{ $t('show') }}
                            </Link>

                            <Link
                                v-if="hasPermission('update_orphans')"
                                :href="route('tenant.orphans.edit', orphan.id)"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                >{{ $t('edit') }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
