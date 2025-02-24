<script lang="ts" setup>
import type { IndexParams, NeedsIndexResource, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import NeedStatus from '@/Pages/Tenant/needs/index/NeedStatus.vue'

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
    needs: PaginationData<NeedsIndexResource>
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
                        :direction="params.directions && params.directions['needable.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'needable.name')"
                    >
                        {{ $t('the_requester') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['zone.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'zone.name')"
                        >{{ $t('validation.attributes.address') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['branch.name']"
                        class="text-start"
                        sortable
                        @click="emit('sort', 'branch.name')"
                        >{{ $t('the_branch') }}
                    </the-table-th>

                    <the-table-th class="text-start">{{ $t('validation.attributes.subject') }}</the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('the_demand') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.status"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'status')"
                    >
                        {{ $t('validation.attributes.the_status') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.note') }}
                    </the-table-th>

                    <the-table-th
                        v-if="hasPermission(['delete_needs', 'update_needs', 'view_needs'])"
                        class="text-center"
                    >
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(need, index) in needs.data" :key="need.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (needs.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link
                            v-if="need.needable.type == 'sponsor'"
                            :href="route('tenant.sponsors.show', need.needable.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ need.needable.name }}
                        </Link>

                        <Link
                            v-else
                            :href="route('tenant.orphans.show', need.needable.id)"
                            class="font-medium rtl:!font-semibold"
                        >
                            {{ need.needable.name }}
                        </Link>

                        <p class="mt-0.5 block whitespace-nowrap text-xs text-slate-500">
                            {{ $t(`needs.${need.needable.type}`) }}
                        </p>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <base-tippy :content="need.needable.family.address">
                            {{ need.needable.family.address }}
                        </base-tippy>

                        <Link
                            :href="route('tenant.zones.index') + `?show=${need.needable.family.zone?.id}`"
                            class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                        >
                            {{ need.needable.family.zone?.name }}
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        <Link
                            :href="route('tenant.branches.index') + `?show=${need.needable.branch?.id}`"
                            class="mt-0.5 block truncate whitespace-nowrap"
                        >
                            <base-tippy :content="need.needable.family.branch?.name">
                                {{ need.needable.family.branch?.name }}
                            </base-tippy>
                        </Link>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        {{ need.subject }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <base-tippy :content="need.demand">
                            <svg-loader class="mx-auto block h-6 w-6" name="icon-file-lines"></svg-loader>
                        </base-tippy>
                    </the-table-td>

                    <the-table-td class="w-30 text-center">
                        <need-status :status="need.status"></need-status>
                    </the-table-td>

                    <the-table-td class="w-40">
                        <!-- FIXME: need note doesn't update without refresh -->
                        <base-tippy v-if="need.note" :content="need.note">
                            <svg-loader class="mx-auto block" name="icon-note"></svg-loader>
                        </base-tippy>

                        <span v-else class="mx-auto block text-center">————</span>
                    </the-table-td>

                    <the-table-td-actions v-if="hasPermission(['delete_needs', 'update_needs', 'view_needs'])">
                        <div class="flex items-center justify-center">
                            <a
                                v-if="hasPermission('view_needs')"
                                class="me-3 flex items-center"
                                href="#"
                                @click.prevent="emit('showDetailsModal', need.id)"
                            >
                                <svg-loader class="me-1 h-5 w-5 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_needs')"
                                class="me-3 flex items-center"
                                href="#"
                                @click.prevent="emit('showEditModal', need.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                {{ $t('edit') }}
                            </a>
                            <a
                                v-if="hasPermission('delete_needs')"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', need.id)"
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
