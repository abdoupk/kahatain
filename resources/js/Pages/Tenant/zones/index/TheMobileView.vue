<script lang="ts" setup>
import type { IndexParams, PaginationData, ZonesIndexResource } from '@/types/types'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    zones: PaginationData<ZonesIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="zone in zones.data" :key="zone.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-4 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ zone.name }}
                    </div>

                    <base-tippy
                        :content="$t('families_count')"
                        class="ms-auto flex w-fit cursor-pointer items-center truncate whitespace-nowrap rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ zone.families_count }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <p>{{ zone.description }}</p>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('added_at')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ zone.created_at }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <a
                                v-if="hasPermission('view_zones')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click.prevent="emit('showDetailsModal', zone.id)"
                                >{{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_zones')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click.prevent="emit('showEditModal', zone.id)"
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
    </div>
</template>
