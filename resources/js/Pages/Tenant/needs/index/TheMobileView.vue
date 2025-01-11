<script lang="ts" setup>
import type { IndexParams, NeedsIndexResource, PaginationData } from '@/types/types'

import NeedStatus from '@/Pages/Tenant/needs/index/NeedStatus.vue'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    needs: PaginationData<NeedsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="need in needs.data" :key="need.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        {{ need.subject }}
                    </div>

                    <base-tippy :content="$t('validation.attributes.the_status')" class="ms-auto">
                        <need-status :status="need.status"></need-status>
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('needable_type') }}
                        </div>

                        {{ need.needable.name }} ({{ $t(`needs.${need.needable.type}`) }})
                    </div>

                    <div class="mt-2 line-clamp-3">
                        {{ need.demand }}
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('added_at')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatDate(need.created_at, 'full') }}
                        </base-tippy>

                        <div class="ms-auto flex items-center">
                            <a
                                v-if="hasPermission('view_needs')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="#"
                                @click.prevent="emit('showDetailsModal', need.id)"
                                >{{ $t('show') }}</a
                            >

                            <a
                                v-if="hasPermission('update_needs')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="#"
                                @click.prevent="emit('showEditModal', need.id)"
                                >{{ $t('edit') }}</a
                            >

                            <a
                                v-if="hasPermission('delete_needs')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', need.id)"
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
