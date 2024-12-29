<script lang="ts" setup>
import type { IndexParams, PaginationData, SponsorsIndexResource } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    sponsors: PaginationData<SponsorsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal'])
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
                        {{ $t('the_sponsor') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('validation.attributes.phone') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.health_status"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'health_status')"
                        >{{ $t('validation.attributes.sponsor.health_status') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions && params.directions['academic_level.i_id']"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'academic_level.i_id')"
                        >{{ $t('validation.attributes.sponsor.academic_level') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.birth_date"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'birth_date')"
                        >{{ $t('validation.attributes.date_of_birth') }}
                    </the-table-th>

                    <the-table-th v-if="hasPermission(['delete_sponsors', 'update_sponsors'])" class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(sponsor, index) in sponsors.data" :key="sponsor.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (sponsors.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <Link
                            v-if="hasPermission('view_sponsors')"
                            :href="route('tenant.sponsors.show', sponsor.id)"
                            class="font-medium"
                        >
                            {{ sponsor.name }}
                        </Link>

                        <span v-else class="font-medium">{{ sponsor.name }}</span>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate">
                        {{ sponsor.phone_number }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ sponsor.health_status }}
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        <base-tippy :content="sponsor.academic_level">
                            {{ sponsor.academic_level }}
                        </base-tippy>

                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            {{ sponsor.academic_level_phase }}
                        </div>
                    </the-table-td>

                    <the-table-td class="whitespace-nowrap text-center">
                        {{ formatDate(sponsor.birth_date, 'long') }}
                    </the-table-td>

                    <the-table-td-actions v-if="hasPermission(['delete_sponsors', 'update_sponsors'])">
                        <div class="flex items-center justify-center">
                            <Link :href="route('tenant.sponsors.show', sponsor.id)" class="me-3 flex items-center">
                                <svg-loader
                                    v-if="hasPermission('show_sponsors')"
                                    class="me-1 h-4 w-4 fill-current"
                                    name="icon-eye"
                                />
                                {{ $t('show') }}
                            </Link>

                            <Link :href="route('tenant.sponsors.edit', sponsor.id)" class="me-3 flex items-center">
                                <svg-loader
                                    v-if="hasPermission('update_sponsors')"
                                    class="me-1 h-4 w-4 fill-current"
                                    name="icon-pen"
                                />
                                {{ $t('edit') }}
                            </Link>
                            <a
                                v-if="hasPermission('delete_sponsors')"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', sponsor.id)"
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
