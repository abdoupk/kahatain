<script lang="ts" setup>
import type { SponsorShowType } from '@/types/sponsors'

import TheAttachementsViewer from '@/Components/Global/TheAttachementsViewer.vue'

import { formatCurrency, omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{ sponsor: SponsorShowType }>()

const incomes = omit(props.sponsor.incomes, [
    'id',
    'cnas_file',
    'casnos_file',
    'ccp_file',
    'bank_file',
    'cnr_file',
    'files',
    'account'
])
</script>

<template>
    <!-- BEGIN: Incomes -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('income information') }}</h2>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div v-for="(income, key) in incomes" :key class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t(`incomes.label.${key}`) }}
                </h2>

                <h3 class="text-base font-medium">{{ formatCurrency(income) }}</h3>
            </div>

            <div class="col-span-12">
                <!-- Begin: CCP account-->
                <h2 class="text-lg font-semibold">
                    {{ $t('incomes.label.ccp_account') }}
                </h2>

                <div class="mt-2 grid grid-cols-12 gap-4">
                    <div class="col-span-12 @xl:col-span-4">
                        <h3 class="text-base font-semibold">
                            {{ $t('incomes.label.monthly_income') }}
                        </h3>

                        <h4 class="font-medium">
                            {{ formatCurrency(sponsor.incomes.account.ccp.monthly_income) }}
                        </h4>
                    </div>

                    <div class="col-span-12 @xl:col-span-4">
                        <h3 class="text-base font-semibold">
                            {{ $t('incomes.label.balance') }}
                        </h3>

                        <h4 class="font-medium">
                            {{ formatCurrency(sponsor.incomes.account.ccp.balance) }}
                        </h4>
                    </div>

                    <div class="col-span-12 @xl:col-span-4">
                        <h3 class="text-base font-semibold">
                            {{ $t('incomes.label.performance_grant') }}
                        </h3>

                        <h4 class="font-medium">
                            {{ formatCurrency(sponsor.incomes.account.ccp.performance_grant) }}
                        </h4>
                    </div>
                </div>
                <!-- End: CCP account-->

                <!-- Begin: Bank account-->
                <h2 class="mt-4 text-lg font-semibold">
                    {{ $t('incomes.label.bank_account') }}
                </h2>

                <div class="mt-2 grid grid-cols-12 gap-4">
                    <div class="col-span-12 @xl:col-span-4">
                        <h3 class="text-base font-semibold">
                            {{ $t('incomes.label.monthly_income') }}
                        </h3>

                        <h4 class="font-medium">
                            {{ formatCurrency(sponsor.incomes.account.bank.monthly_income) }}
                        </h4>
                    </div>

                    <div class="col-span-12 @xl:col-span-4">
                        <h3 class="text-base font-semibold">
                            {{ $t('incomes.label.balance') }}
                        </h3>

                        <h4 class="font-medium">
                            {{ formatCurrency(sponsor.incomes.account.bank.balance) }}
                        </h4>
                    </div>

                    <div class="col-span-12 @xl:col-span-4">
                        <h3 class="text-base font-semibold">
                            {{ $t('incomes.label.performance_grant') }}
                        </h3>

                        <h4 class="font-medium">
                            {{ formatCurrency(sponsor.incomes.account.bank.performance_grant) }}
                        </h4>
                    </div>
                </div>
                <!-- End: Bank account-->
            </div>
        </div>
    </div>
    <!-- END: Incomes -->

    <the-attachements-viewer
        :images="sponsor.incomes.files.images"
        :no-files-message="$t('no_residence_certificate')"
        :pdf="sponsor.incomes.files.pdf"
    ></the-attachements-viewer>
</template>
