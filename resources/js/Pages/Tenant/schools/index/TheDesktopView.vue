<script lang="ts" setup>
import type { IndexParams, PaginationData, SchoolsIndexResource } from '@/types/types'

import print from 'print-js'
import { ref } from 'vue'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
import TheTableTdActions from '@/Components/Global/DataTable/TheTableTdActions.vue'
import TheTableTh from '@/Components/Global/DataTable/TheTableTh.vue'
import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatDate, formatUrl, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    schools: PaginationData<SchoolsIndexResource>
    params: IndexParams
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showDeleteModal', 'showEditModal', 'showDetailsModal'])

const printStarting = ref<boolean>(false)

const selectedSchoolId = ref<string>('')

const printPdf = (schoolId: string) => {
    selectedSchoolId.value = schoolId

    print({
        printable: formatUrl(route('tenant.schools.export.pdf', schoolId)),
        type: 'pdf',
        onLoadingStart: () => {
            printStarting.value = true
        },
        onLoadingEnd: () => {
            printStarting.value = false
        }
    })
}
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
                        {{ $t('the_school') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.quota"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'quota')"
                        >{{ $t('quota_total') }}
                    </the-table-th>

                    <the-table-th
                        :direction="params.directions?.created_at"
                        class="text-center"
                        sortable
                        @click="emit('sort', 'created_at')"
                    >
                        {{ $t('added_at') }}
                    </the-table-th>

                    <the-table-th class="text-center">
                        {{ $t('actions') }}
                    </the-table-th>
                </base-tr-table>
            </base-thead-table>

            <base-tbody-table>
                <base-tr-table v-for="(school, index) in schools.data" :key="school.id" class="intro-x">
                    <the-table-td class="w-16">
                        {{ (schools.meta.from ?? 0) + index }}
                    </the-table-td>

                    <the-table-td class="!min-w-40 !max-w-40 truncate">
                        <a
                            class="font-medium rtl:!font-semibold"
                            href="#"
                            @click.prevent="emit('showDetailsModal', school.id)"
                        >
                            {{ school.name }}
                        </a>
                    </the-table-td>

                    <the-table-td class="max-w-40 truncate text-center">
                        {{ school.quota }}
                    </the-table-td>

                    <the-table-td class="text-center">
                        {{ formatDate(school.created_at, 'full') }}
                    </the-table-td>

                    <the-table-td-actions>
                        <div class="flex items-center justify-center">
                            <a
                                v-if="hasPermission('print_schools')"
                                :class="{ 'pointer-events-none opacity-70': !school.should_print }"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="printPdf(school.id)"
                            >
                                <svg-loader
                                    v-if="!printStarting || school.id !== selectedSchoolId"
                                    class="me-1 h-4 w-4 fill-current"
                                    name="icon-print"
                                ></svg-loader>

                                <spinner-loader
                                    v-if="printStarting && school.id === selectedSchoolId"
                                    class="me-1 h-4 w-4"
                                ></spinner-loader>

                                {{ $t('print') }}
                            </a>

                            <a
                                v-if="hasPermission('view_schools')"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="emit('showDetailsModal', school.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-eye" />
                                {{ $t('show') }}
                            </a>

                            <a
                                v-if="hasPermission('update_schools')"
                                class="me-3 flex items-center"
                                href="javascript:void(0)"
                                @click.prevent="emit('showEditModal', school.id)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-pen" />
                                {{ $t('edit') }}
                            </a>

                            <a
                                v-if="hasPermission('delete_schools')"
                                class="flex items-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('showDeleteModal', school.id)"
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
