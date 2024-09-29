<script lang="ts" setup>
import type { IndexParams, MembersIndexResource, PaginationData } from '@/types/types'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ members: PaginationData<MembersIndexResource>; params: IndexParams }>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="@container">
        <div class="intro-y col-span-12 hidden overflow-auto @3xl:block lg:overflow-visible !z-30">
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
                            {{ $t('the_member') }}
                        </the-table-th>

                        <the-table-th
                            :direction="params.directions?.email"
                            class="text-center"
                            sortable
                            @click="emit('sort', 'email')"
                        >
                            {{ $t('validation.attributes.email') }}
                        </the-table-th>

                        <the-table-th class="text-center">{{ $t('validation.attributes.phone') }}</the-table-th>

                        <the-table-th class="text-center">
                            {{ $t('validation.attributes.zone') }}
                        </the-table-th>

                        <the-table-th v-if="hasPermission(['update_members', 'delete_members'])" class="text-center">
                            {{ $t('actions') }}
                        </the-table-th>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table v-for="(member, index) in members.data" :key="member.id" class="intro-x">
                        <the-table-td class="w-16">
                            {{ (members.meta.from ?? 0) + index }}
                        </the-table-td>

                        <the-table-td class="!min-w-40 !max-w-40 truncate">
                            <a class="font-medium" href="#" @click.prevent="emit('showDetailsModal', member.id)">
                                {{ member.name }}
                            </a>
                        </the-table-td>

                        <the-table-td class="max-w-40 truncate">
                            {{ member.email }}
                        </the-table-td>

                        <the-table-td class="text-center">
                            {{ member.phone }}
                        </the-table-td>

                        <the-table-td class="w-40">
                            <div class="whitespace-nowrap text-center">
                                {{ member.zone?.name }}
                            </div>
                        </the-table-td>

                        <the-table-td-actions v-if="hasPermission(['update_members', 'delete_members'])">
                            <div class="flex items-center justify-center">
                                <a
                                    v-if="hasPermission('update_members')"
                                    class="me-3 flex items-center"
                                    href="javascript:void(0)"
                                    @click.prevent="emit('showEditModal', member.id)"
                                >
                                    <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                    {{ $t('edit') }}
                                </a>
                                <a
                                    v-if="hasPermission('delete_members')"
                                    class="flex items-center text-danger"
                                    href="javascript:void(0)"
                                    @click="emit('showDeleteModal', member.id)"
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
            <div v-for="member in members.data" :key="member.id" class="intro-y col-span-12 @xl:col-span-6">
                <div class="box p-5">
                    <div class="flex">
                        <div class="me-3 truncate text-lg font-medium">
                            {{ member.name }}
                        </div>
                        <div
                            class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                        >
                            {{ member.phone }}
                        </div>
                    </div>
                    <div class="mt-6 flex">
                        <div class="w-3/4">
                            <p class="truncate">{{ member.email }}</p>
                            <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                                {{ member.zone?.name }}
                            </div>
                            <div
                                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                            >
                                {{ formatDate(member.created_at, 'long') }}
                            </div>
                        </div>
                        <div class="flex w-1/4 items-center justify-end">
                            <a
                                v-if="hasPermission('update_members')"
                                class="me-2 font-semibold text-slate-500 dark:text-slate-400"
                                href="javascript:void(0)"
                                @click.prevent="emit('showEditModal', member.id)"
                                >{{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission('delete_members')"
                                class="font-semibold text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', member.id)"
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
