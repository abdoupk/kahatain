<script lang="ts" setup>
import type { EidAlAdhaFamiliesResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseFormSelect from '@/Components/Base/form/BaseFormSelect.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{
    families: PaginationData<EidAlAdhaFamiliesResource>
    params: IndexParams
}>()

const emit = defineEmits(['change-status'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="family in families.data" :key="family.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate ltr:font-medium rtl:text-lg rtl:font-semibold">
                        <Link v-if="hasPermission('view_families')" :href="route('tenant.families.show', family.id)">
                            {{ family.sponsor.name }}
                        </Link>

                        <p v-else>{{ family.sponsor.name }}</p>
                    </div>

                    <base-tippy
                        :content="$t('income_rate')"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ formatCurrency(family.income_rate) }}
                    </base-tippy>
                </div>

                <div class="mt-4">
                    <div class="flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('sponsor_phone_number') }}
                        </div>
                        {{ family.sponsor.phone_number }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('orphans_count') }}
                        </div>
                        {{ family.orphans_count }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.address') }}
                        </div>

                        <base-tippy :content="family.address" class="truncate">{{ family.address }}</base-tippy>
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.zone') }}
                        </div>
                        {{ family.zone?.name }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="mt-2 w-28 rtl:!font-semibold">
                            {{ $t('validation.attributes.the_status') }}
                        </div>

                        <div class="w-full">
                            <base-form-select
                                :value="family.status"
                                class="ms-4 w-1/2"
                                @change="
                                    emit('change-status', {
                                        id: family.id,
                                        status: $event.target.value
                                    })
                                "
                            >
                                <option selected value="">{{ $t('filters.select_an_option') }}</option>
                                <option value="benefit">{{ $t('benefit') }}</option>
                                <option value="dont_benefit">{{ $t('dont_benefit') }}</option>
                                <option value="sacrificed">
                                    {{ $t('sacrificed') }}
                                </option>
                                <option value="meat">{{ $t('meat') }}</option>
                                <option value="benefactor">{{ $t('benefactor') }}</option>
                            </base-form-select>
                        </div>
                    </div>

                    <div class="mt-2 flex">
                        <base-tippy
                            :content="$t('incomes.label.total_income')"
                            class="flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatCurrency(family.total_income) }}
                        </base-tippy>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
