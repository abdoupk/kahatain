<script lang="ts" setup>
import { formatCurrency } from '../../../utils/helper'

import { useBenefactorsStore } from '@/stores/benefactors'
import { Link } from '@inertiajs/vue3'

import BaseTable from '@/Components/Base/table/BaseTable.vue'
import BaseTbodyTable from '@/Components/Base/table/BaseTbodyTable.vue'
import BaseTdTable from '@/Components/Base/table/BaseTdTable.vue'
import BaseThTable from '@/Components/Base/table/BaseThTable.vue'
import BaseTheadTable from '@/Components/Base/table/BaseTheadTable.vue'
import BaseTrTable from '@/Components/Base/table/BaseTrTable.vue'
import ShowModal from '@/Components/Global/ShowModal.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const benefactorsStore = useBenefactorsStore()
</script>

<template>
    <show-modal :open :title size="xl" @close="emit('close')">
        <template #description>
            <!-- Begin: Name-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.name') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ benefactorsStore.benefactor.name }}
                </h3>
            </div>
            <!-- End: Name-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ benefactorsStore.benefactor.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="route('tenant.members.index') + `?show=${benefactorsStore.benefactor.creator?.id}`"
                    class="mt-1 rtl:font-medium"
                >
                    {{ benefactorsStore.benefactor.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Address-->
            <div class="col-span-12 sm:col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.address') }}</h2>

                <p class="mt-1 rtl:font-medium">
                    {{ benefactorsStore.benefactor.address }}
                </p>
            </div>
            <!-- End: Address-->

            <!-- Begin: Sponsorships-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">{{ $t('the_sponsorships') }}</h2>

                <div class="mt-1 overflow-x-auto" v-if="benefactorsStore.benefactor.sponsorships.length">
                    <base-table striped sm>
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
                            </base-tr-table>
                        </base-thead-table>

                        <base-tbody-table>
                            <base-tr-table
                                v-for="(sponsorship, index) in benefactorsStore.benefactor.sponsorships"
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

                                <base-td-table>
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
    </show-modal>
</template>
