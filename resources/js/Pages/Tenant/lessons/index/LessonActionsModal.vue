<script lang="ts" setup>
import { useLessonsStore } from '@/stores/lessons'
import type { EventApi } from '@fullcalendar/core'
import { defineAsyncComponent } from 'vue'

import BaseDialog from '@/Components/Base/headless/Dialog/BaseDialog.vue'
import BaseDialogPanel from '@/Components/Base/headless/Dialog/BaseDialogPanel.vue'
import TheModalLoader from '@/Components/Global/TheModalLoader.vue'

const BaseButton = defineAsyncComponent(() => import('@/Components/Base/button/BaseButton.vue'))

const BaseTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTable.vue'))

const BaseTbodyTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTbodyTable.vue'))

const BaseTdTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTdTable.vue'))

const BaseThTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseThTable.vue'))

const BaseTheadTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTheadTable.vue'))

const BaseTrTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTrTable.vue'))

const SpinnerButtonLoader = defineAsyncComponent(() => import('@/Components/Global/SpinnerButtonLoader.vue'))

defineProps<{
    open: boolean
    deleteProgress: boolean
    eventInfo: EventApi | null
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['close', 'delete', 'edit'])

const lessonsStore = useLessonsStore()
</script>

<template>
    <base-dialog :open size="xl" @close="emit('close')">
        <base-dialog-panel>
            <suspense suspensible>
                <template #default>
                    <div>
                        <div class="p-5 text-center text-2xl leading-8">
                            {{ eventInfo?.title }}
                        </div>

                        <div class="p-5">
                            <div class="grid grid-cols-12 gap-4">
                                <h1 class="col-span-3 rtl:!font-semibold">
                                    {{ $t('date_and_time') }}
                                </h1>

                                <p class="col-span-9">
                                    {{ lessonsStore.lesson?.formated_date }}
                                </p>
                            </div>

                            <div class="mt-4 grid grid-cols-12 gap-4">
                                <h1 class="col-span-3 rtl:!font-semibold">
                                    {{ $t('quota_total') }}
                                </h1>

                                <p class="col-span-9">
                                    {{ lessonsStore.lesson.lesson?.quota }}
                                </p>
                            </div>

                            <div class="mt-4 grid grid-cols-12 gap-4">
                                <h1 class="col-span-3 rtl:!font-semibold">
                                    {{ $t('school_name') }}
                                </h1>

                                <p class="col-span-9">
                                    {{ lessonsStore.lesson?.school?.name }}
                                </p>
                            </div>

                            <div class="mt-4 grid grid-cols-12 gap-4">
                                <h1 class="col-span-3 rtl:!font-semibold">
                                    {{ $t('the_subject') }}
                                </h1>

                                <p class="col-span-9">
                                    {{ lessonsStore.lesson?.subject?.name }}
                                </p>
                            </div>

                            <div class="mt-4 grid grid-cols-12 gap-4">
                                <h1 class="col-span-3 rtl:!font-semibold">
                                    {{ $t('academic_level') }}
                                </h1>

                                <p class="col-span-9">
                                    {{ lessonsStore.lesson?.academic_level?.name }}
                                </p>
                            </div>
                        </div>

                        <div class="overflow-x-auto px-5 pb-5">
                            <base-table striped>
                                <base-thead-table>
                                    <base-tr-table>
                                        <base-th-table class="whitespace-nowrap">#</base-th-table>
                                        <base-th-table class="whitespace-nowrap">
                                            {{ $t('validation.attributes.first_name') }}
                                        </base-th-table>
                                        <base-th-table class="whitespace-nowrap">
                                            {{ $t('validation.attributes.last_name') }}
                                        </base-th-table>
                                        <base-th-table class="whitespace-nowrap">
                                            {{ $t('sponsor_phone_number') }}
                                        </base-th-table>
                                    </base-tr-table>
                                </base-thead-table>

                                <base-tbody-table>
                                    <base-tr-table
                                        v-for="(orphan, index) in lessonsStore.lesson.orphans"
                                        :key="orphan.id"
                                        class="text-center"
                                    >
                                        <base-td-table>{{ index + 1 }}</base-td-table>
                                        <base-td-table>{{ orphan.first_name }}</base-td-table>
                                        <base-td-table>{{ orphan.last_name }}</base-td-table>
                                        <base-td-table>{{ orphan.sponsor_phone }}</base-td-table>
                                    </base-tr-table>
                                </base-tbody-table>
                            </base-table>
                        </div>

                        <div class="flex justify-center px-5 pb-8 text-center">
                            <base-button
                                class="me-2 w-24"
                                type="button"
                                variant="outline-secondary"
                                @click="emit('close')"
                            >
                                {{ $t('cancel') }}
                            </base-button>

                            <base-button
                                ref="{deleteButtonRef}"
                                class="me-2 w-24"
                                type="button"
                                variant="primary"
                                @click.prevent="emit('edit')"
                            >
                                {{ $t('edit') }}
                            </base-button>

                            <base-button
                                ref="{deleteButtonRef}"
                                class="w-24"
                                type="button"
                                variant="danger"
                                @click="emit('delete')"
                            >
                                <spinner-button-loader :show="deleteProgress"></spinner-button-loader>

                                {{ $t('delete') }}
                            </base-button>
                        </div>
                    </div>
                </template>

                <template #fallback>
                    <the-modal-loader></the-modal-loader>
                </template>
            </suspense>
        </base-dialog-panel>
    </base-dialog>
</template>
