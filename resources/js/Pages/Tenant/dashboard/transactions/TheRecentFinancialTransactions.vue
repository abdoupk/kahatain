<script lang="ts" setup>
import type { RecentTransactionsType } from '@/types/dashboard'

import { Link } from '@inertiajs/vue3'

import TheAvatar from '@/Components/Global/TheAvatar.vue'

import { formatCurrency } from '@/utils/helper'

defineProps<{
    recentTransactions: RecentTransactionsType
}>()
</script>

<template>
    <!-- BEGIN: Transactions -->
    <suspense suspensible>
        <div class="col-span-12 mt-3 md:col-span-6 xl:col-span-4 2xl:col-span-12 2xl:mt-8">
            <div class="intro-x flex h-10 items-center">
                <h2 class="me-5 truncate text-lg font-medium rtl:font-semibold">{{ $t('Transactions') }}</h2>
            </div>

            <div class="mt-5">
                <template v-if="recentTransactions.length > 0">
                    <div v-for="transaction in recentTransactions" :key="transaction.id" class="intro-x">
                        <div class="box zoom-in mb-3 flex items-center px-5 py-3">
                            <div class="image-fit h-10 w-10 flex-none overflow-hidden rounded-full">
                                <Link :href="route('tenant.members.index') + '?show=' + transaction.receiver.id">
                                    <the-avatar
                                        :gender="transaction.receiver.gender"
                                        :name="transaction.receiver.name"
                                    ></the-avatar>
                                </Link>
                            </div>
                            <div class="me-auto ms-4">
                                <div class="font-medium">{{ transaction.receiver.name }}</div>
                                <div class="mt-0.5 text-xs text-slate-500">
                                    {{ transaction.date }}
                                </div>
                            </div>
                            <div
                                :class="{
                                    'text-success': transaction.amount > 0,
                                    'text-danger': transaction.amount < 0
                                }"
                            >
                                {{ formatCurrency(Math.abs(transaction.amount)) }}
                            </div>
                        </div>
                    </div>

                    <Link
                        :href="route('tenant.financial.index')"
                        class="intro-x block w-full rounded-md border border-dotted border-slate-400 py-3 text-center text-slate-500 dark:border-darkmode-300"
                    >
                        {{ $t('Show More') }}
                    </Link>
                </template>

                <div v-else class="mt-8 text-center text-lg font-medium text-slate-500">
                    {{ $t('no_financial_transactions') }}
                </div>
            </div>
        </div>
    </suspense>
    <!-- END: Transactions -->
</template>
