<script lang="ts" setup>
import type { IndexParams, PaginationData, RolesIndexResource } from '@/types/types'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

import { formatDate } from '@/utils/helper'

defineProps<{ roles: PaginationData<RolesIndexResource>; params: IndexParams }>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
</script>

<template>
    <div class="@container">
        <div class="intro-y !z-30 col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible">
            <base-table class="mt-2 border-separate border-spacing-y-[10px]">
                <base-thead-table>
                    <base-tr-table>
                        <the-table-th class="text-start"> #</the-table-th>

                        <the-table-th
                            :direction="params.directions?.name"
                            class="text-start"
                            sortable
                            @click="emit('sort', 'name')"
                        >
                            {{ $t('the_role') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.permissions_count"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'permissions_count')"
                        >
                            {{ $t('permissions_count') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.users_count"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'users_count')"
                        >
                            {{ $t('users_count') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.created_at"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'created_at')"
                        >
                            {{ $t('validation.attributes.created_at') }}
                        </the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('actions') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(role, index) in roles.data" :key="role.uuid" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (roles.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="!min-w-40 !max-w-40 truncate">
                            {{ role.name }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ role.permissions_count }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ role.users_count }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ formatDate(role.created_at, 'full') }}
                        </the-table-td>

                        <the-table-td-actions>
                            <div class="flex items-center justify-center">
                                <a
                                    class="me-3 flex items-center"
                                    href="javascript:void(0)"
                                    @click="emit('showEditModal', role.uuid)"
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                    {{ $t('edit') }}
                                </a>
                                <a
                                    class="flex items-center text-danger"
                                    href="javascript:void(0)"
                                    @click="emit('showDeleteModal', role.uuid)"
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
            <div v-for="role in roles.data" :key="role.uuid" class="intro-y !z-10 col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            {{ role.name }}
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            {{ formatDate(role.created_at, 'full') }}
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="flex w-3/4 flex-col gap-4">
                            <div class="flex">
                                <div class="w-28">
                                    {{ $t('users_count') }}
                                </div>
                                {{ role.users_count }}
                            </div>

                            <div class="flex">
                                <div class="w-28">
                                    {{ $t('permissions_count') }}
                                </div>

                                {{ role.permissions_count }}
                            </div>
                        </div>

                        <div class="flex w-1/4 items-center justify-end">
                            <a
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="#"
                                @click="emit('showEditModal', role.uuid)"
                                >{{ $t('edit') }}
                            </a>
                            <a
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', role.uuid)"
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
