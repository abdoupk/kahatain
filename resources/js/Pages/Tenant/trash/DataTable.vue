<script lang="ts" setup>
import type { IndexParams, PaginationData, TrashIndexResource } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, formatDateAndTime, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ items: PaginationData<TrashIndexResource>; params: IndexParams }>()

const emit = defineEmits(['showDeleteModal', 'restore'])
</script>

<template>
    <div class="-mt-5 @container">
        <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th class="text-start">
                            {{ $t('the_item') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('deleted_by') }}
                        </the-table-th>

                        <the-table-th class="text-center">{{ $t('validation.attributes.deleted_at') }}</the-table-th>

                        <the-table-th v-if="hasPermission(['restore_trash', 'destroy_trash'])" class="text-center">
                            {{ $t('actions') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(item, index) in items.data" :key="item.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (items.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="!min-w-40 !max-w-40 truncate">
                            <p v-if="item.type === 'finance'" class="font-medium">
                                {{ $t(item.name) }} ({{ $t(item.type) }})
                            </p>

                            <p v-else class="font-medium">{{ item.name }} ({{ $t(item.type) }})</p>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate text-center">
                            <Link :href="route('tenant.members.index') + `?show=${item.user_id}`">
                                {{ item.user_name }}
                            </Link>
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ formatDate(item.deleted_at, 'full') }}
                        </the-table-td>

                        <the-table-td-actions v-if="hasPermission(['restore_trash', 'destroy_trash'])">
                            <div class="flex items-center justify-center">
                                <a
                                    v-if="hasPermission('restore_trash')"
                                    class="me-3 flex items-center"
                                    href="javascript:void(0)"
                                    @click.prevent="emit('restore', route(item.restore_url, item.id))"
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-trash-undo" />
                                    {{ $t('restore') }}
                                </a>
                                <a
                                    v-if="hasPermission('destroy_trash')"
                                    class="flex items-center text-danger"
                                    href="javascript:void(0)"
                                    @click="
                                        emit('showDeleteModal', {
                                            id: item.id,
                                            url: item.force_delete_url
                                        })
                                    "
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-trash-can" />
                                    {{ $t('delete') }}
                                </a>
                            </div>
                        </the-table-td-actions>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
            <div v-for="item in items.data" :key="item.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            {{ item.name }}
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            {{ formatDateAndTime(item.deleted_at) }}
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="w-3/4">
                            <p class="truncate">{{ item.user_name }}</p>
                        </div>
                        <div class="flex w-1/4 items-center justify-end">
                            <a
                                v-if="hasPermission('restore_trash')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click.prevent="emit('restore', item.id)"
                                >{{ $t('restore') }}
                            </a>
                            <a
                                v-if="hasPermission('destroy_trash')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', item.id)"
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
