<script lang="ts" setup>
import type { FamiliesIndexResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<FamiliesIndexResource>
    params: IndexParams
}>()

const emit = defineEmits(['showDeleteModal'])
</script>

<template>
    <div class="@3xl:hidden col-span-12 my-8 grid grid-cols-12 gap-4">
        <div v-for="family in families.data" :key="family.id" class="intro-y @xl:col-span-6 !z-10 col-span-12">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ family.name }}
                    </div>

                    <base-tippy
                        :content="$t('file_number')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ family.file_number }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('the_sponsor') }}
                        </div>
                        {{ family.sponsor.name }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('orphans_count') }}
                        </div>
                        {{ family.orphans_count }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.address') }}
                        </div>
                        {{ family.address }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.zone') }}
                        </div>
                        {{ family.zone?.name }}
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('filters.starting_sponsorship_date')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(family.start_date, 'full') }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <Link
                                v-if="hasPermission('view_families')"
                                :href="route('tenant.families.show', family.id)"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                >{{ $t('show') }}
                            </Link>

                            <Link
                                v-if="hasPermission('update_families')"
                                :href="route('tenant.families.edit', family.id)"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                >{{ $t('edit') }}
                            </Link>

                            <a
                                v-if="hasPermission('delete_families')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', family.id)"
                            >
                                {{ $t('delete') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
