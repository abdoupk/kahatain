<script lang="ts" setup>
import type { RecentFamiliesType } from '@/types/dashboard'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    recentFamilies: RecentFamiliesType
}>()

const emit = defineEmits(['deleteFamily'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="family in recentFamilies" :key="family.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        {{ family.name }}
                    </div>

                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        <base-tippy :content="$t('orphans_count')">
                            {{ family.orphans_count }}
                        </base-tippy>
                    </div>
                </div>

                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="truncate">{{ family.address }}</p>

                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ family.zone?.name }}
                        </div>
                    </div>

                    <div class="flex w-1/4 items-center justify-end">
                        <Link
                            :href="route('tenant.families.show', family.id)"
                            class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                            >{{ $t('edit') }}
                        </Link>

                        <a
                            v-if="hasPermission('delete_families')"
                            class="font-semibold text-danger"
                            href="javascript:void(0)"
                            @click.prevent="emit('deleteFamily', family.id)"
                        >
                            {{ $t('delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
