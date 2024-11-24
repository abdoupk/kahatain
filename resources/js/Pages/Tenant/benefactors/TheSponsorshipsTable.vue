<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'
import { defineAsyncComponent } from 'vue'

import { formatCurrency, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const BaseTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTable.vue'))

const BaseTbodyTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTbodyTable.vue'))

const BaseTdTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTdTable.vue'))

const BaseThTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseThTable.vue'))

const BaseTheadTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTheadTable.vue'))

const BaseTrTable = defineAsyncComponent(() => import('@/Components/Base/table/BaseTrTable.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/Global/SvgLoader.vue'))

defineProps<{
    sponsorships: object[]
    editable?: boolean
}>()

const emit = defineEmits(['delete-sponsorship'])
</script>

<template>
    <!-- Begin: Sponsorships-->
    <div class="col-span-12">
        <h2 class="text-base rtl:font-semibold">{{ $t('the_sponsorships') }}</h2>

        <div v-if="sponsorships.length" class="mt-1 overflow-x-auto">
            <base-table sm striped>
                <base-thead-table>
                    <base-tr-table>
                        <base-th-table class="whitespace-nowrap">#</base-th-table>

                        <base-th-table class="whitespace-nowrap">
                            {{ $t('the_recipient') }}
                        </base-th-table>

                        <base-th-table class="whitespace-nowrap">
                            {{ $t('the_value') }}
                        </base-th-table>

                        <base-th-table class="whitespace-nowrap">
                            {{ $t('sponsorship_type') }}
                        </base-th-table>

                        <base-th-table class="whitespace-nowrap">
                            {{ $t('added_at') }}
                        </base-th-table>

                        <base-th-table class="whitespace-nowrap">{{ $t('created_by') }}</base-th-table>

                        <base-th-table v-if="editable" class="whitespace-nowrap">
                            {{ $t('actions') }}
                        </base-th-table>
                    </base-tr-table>
                </base-thead-table>

                <base-tbody-table>
                    <base-tr-table
                        v-for="(sponsorship, index) in sponsorships"
                        :key="sponsorship.id"
                        class="text-center"
                    >
                        <base-td-table> {{ index + 1 }}</base-td-table>

                        <base-td-table>
                            {{ sponsorship.recipientable.name }}

                            <p class="mt-0.5 text-xs font-semibold">
                                {{ $t(`the_${sponsorship.recipientable.recipientable_type}`) }}
                            </p>
                        </base-td-table>

                        <base-td-table dir="rtl">
                            {{ formatCurrency(sponsorship.amount) }}
                        </base-td-table>

                        <base-td-table>
                            {{ $t(`sponsorship_type.${sponsorship.sponsorship_type}`) }}
                        </base-td-table>

                        <base-td-table class="whitespace-nowrap">
                            {{ sponsorship.readable_created_at }}
                        </base-td-table>

                        <base-td-table>
                            <Link
                                :href="route('tenant.members.index') + '?show=' + sponsorship.creator?.id"
                                class="font-semibold text-slate-500"
                            >
                                {{ sponsorship.creator?.name }}
                            </Link>
                        </base-td-table>

                        <base-td-table v-if="editable">
                            <a
                                v-if="hasPermission('delete_sponsorships')"
                                class="flex items-center justify-center text-danger"
                                href="javascript:void(0)"
                                @click="emit('delete-sponsorship', index)"
                            >
                                <svg-loader class="me-1 h-4 w-4 fill-current" name="icon-trash-can" />
                                {{ $t('delete') }}
                            </a>
                        </base-td-table>
                    </base-tr-table>
                </base-tbody-table>
            </base-table>
        </div>

        <p v-else class="mt-1 text-center text-base rtl:font-semibold">
            {{ $t('no_sponsorships') }}
        </p>
    </div>
    <!-- End: Sponsorships-->
</template>
