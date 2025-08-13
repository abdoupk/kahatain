<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="sponsor in sponsors.data" :key="sponsor.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ sponsor.name }}
                    </div>

                    <base-tippy
                        :content="$t('family_status')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ $t(`sponsor_types.${sponsor.sponsor_type}`) }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('academic_level') }}
                        </div>
                        {{ sponsor.academic_level }} ({{ sponsor.academic_level_phase }})
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('income_rate') }}
                        </div>
                        {{ formatCurrency(sponsor.income_rate) }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.sponsor.health_status') }}
                        </div>
                        {{ sponsor.health_status }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.sponsor.function') }}
                        </div>
                        {{ sponsor.function }}
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('filters.birth_date')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(sponsor.birth_date, 'full') }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <Link
                                v-if="hasPermission('view_sponsors')"
                                :href="route('tenant.sponsors.show', sponsor.id)"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                >{{ $t('show') }}
                            </Link>

                            <Link
                                v-if="hasPermission('update_sponsors')"
                                :href="route('tenant.sponsors.edit', sponsor.id)"
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
