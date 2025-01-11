<script lang="ts" setup>
import type { IndexParams, MembersIndexResource, PaginationData } from '@/types/types'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    members: PaginationData<MembersIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])
</script>

<template>
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
                        <a
                            v-if="hasPermission('view_members')"
                            class="font-medium"
                            href="#"
                            @click.prevent="emit('showDetailsModal', member.id)"
                        >
                            {{ member.name }}
                        </a>

                        <a v-else class="font-medium" href="#">
                            {{ member.name }}
                        </a>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <base-tippy :content="member.email">
                            {{ member.email }}
                        </base-tippy>
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ member.phone }}
                    </the-table-td>

                    <the-table-td class="w-40">
                        <div class="whitespace-nowrap text-center">
                            {{ member.zone?.name }}
                        </div>
                    </the-table-td>

                    <the-table-td-actions v-if="hasPermission(['update_members', 'delete_members', 'view_members'])">
                        <div class="flex items-center justify-center">
                            <a
                                v-if="hasPermission('view_members')"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="emit('showDetailsModal', member.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </a>

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
</template>
