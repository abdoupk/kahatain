<script lang="ts" setup>
import { useFinancialTransactionsStore } from '@/stores/financial-transactions'
import { Link } from '@inertiajs/vue3'

import ShowModal from '@/Components/Global/ShowModal.vue'

import { formatCurrency } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    open: boolean
    title: string
}>()

// Define custom event emitter for 'close' event
const emit = defineEmits(['close'])

const financialTransactionsStore = useFinancialTransactionsStore()
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description>
            <!-- Begin: Receiving Member-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('receiving_member') }}</h2>

                <Link
                    :href="
                        route('tenant.members.index') +
                        `?show=${financialTransactionsStore.financialTransaction.creator?.id}`
                    "
                    class="mt-1 rtl:font-medium"
                >
                    {{ financialTransactionsStore.financialTransaction.creator?.name }}
                </Link>
            </div>
            <!-- End: Receiving Member-->

            <!-- Begin: Amount-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('the_amount') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ formatCurrency(financialTransactionsStore.financialTransaction.amount) }}
                </h3>
            </div>
            <!-- End: Amount-->

            <!-- Begin: Date-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('the date') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ financialTransactionsStore.financialTransaction.readable_date }}
                </h3>
            </div>
            <!-- End: Date-->

            <!-- Begin: Created At-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.created_at') }}</h2>

                <h3 class="mt-1 rtl:font-medium">
                    {{ financialTransactionsStore.financialTransaction.readable_created_at }}
                </h3>
            </div>
            <!-- End: Created At-->

            <!-- Begin: Creator-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('created_by') }}</h2>

                <Link
                    :href="
                        route('tenant.members.index') +
                        `?show=${financialTransactionsStore.financialTransaction.creator?.id}`
                    "
                    class="mt-1 rtl:font-medium"
                >
                    {{ financialTransactionsStore.financialTransaction.creator?.name }}
                </Link>
            </div>
            <!-- End: Creator-->

            <!-- Begin: Specification-->
            <div class="col-span-6">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.specification') }}</h2>

                <p class="mt-1 rtl:font-medium">
                    {{ $t(financialTransactionsStore.financialTransaction.specification) }}
                </p>
            </div>
            <!-- End: Specification-->

            <!-- Begin: Description-->
            <div class="col-span-12">
                <h2 class="rtl:font-semibold">{{ $t('validation.attributes.description') }}</h2>

                <p class="mt-1 rtl:font-medium">{{ financialTransactionsStore.financialTransaction.description }}</p>
            </div>
            <!-- End: Description-->
        </template>
    </show-modal>
</template>
