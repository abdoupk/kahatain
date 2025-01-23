<script lang="ts" setup>
import type { IndexParams, MeatDistributionFamiliesResource, PaginationData } from '@/types/types'

import { useMeatDistributionStore } from '@/stores/meat-distribution'
import { Link } from '@inertiajs/vue3'

import BaseFormSwitch from '@/Components/Base/form/form-switch/BaseFormSwitch.vue'
import BaseFormSwitchInput from '@/Components/Base/form/form-switch/BaseFormSwitchInput.vue'
import BaseFormSwitchLabel from '@/Components/Base/form/form-switch/BaseFormSwitchLabel.vue'
import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { formatCurrency, hasPermission } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    families: PaginationData<MeatDistributionFamiliesResource>
    params: IndexParams
}>()

const meatDistributionStore = useMeatDistributionStore()

const checkAll = ($event) => {
    // Get all family IDs from props.families
    const families = props.families.data.map((family) => family.id)

    if ($event.target.checked) {
        // If checked, add all families to selectedFamilies
        if (meatDistributionStore.meatDistribution.families.length) {
            // Avoid duplication by filtering out existing ones
            meatDistributionStore.meatDistribution.families = [
                ...new Set([...meatDistributionStore.meatDistribution.families, ...families])
            ]
        } else {
            meatDistributionStore.meatDistribution.families = families
        }
    } else {
        // If unchecked, remove the current families from selectedFamilies
        meatDistributionStore.meatDistribution.families = meatDistributionStore.meatDistribution.families.filter(
            (id) => !families.includes(id)
        )
    }
}
</script>

<template>
    <base-form-switch class="intro-y -mb-2 mt-6 text-lg @3xl:hidden">
        <base-form-switch-input
            id="check_all"
            :checked="meatDistributionStore.meatDistribution.families.length"
            type="checkbox"
            @change="checkAll"
        ></base-form-switch-input>

        <base-form-switch-label class="whitespace-nowrap text-nowrap" htmlFor="check_all">
            {{ $t('check_all') }}
        </base-form-switch-label>
    </base-form-switch>

    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="family in families.data" :key="family.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box px-5 pb-5 pt-3">
                <base-form-switch-input
                    v-model="meatDistributionStore.meatDistribution.families"
                    :value="family.id"
                    class="mb-2"
                    type="checkbox"
                ></base-form-switch-input>

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
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('sponsor_phone_number') }}
                        </div>
                        {{ family.sponsor.phone_number }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('orphans_count') }}
                        </div>
                        {{ family.orphans_count }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('aggregate_red_meat_benefit') }}
                        </div>
                        {{ family.aggregate_red_meat_benefit }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('aggregate_white_meat_benefit') }}
                        </div>
                        {{ family.aggregate_white_meat_benefit }}
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('validation.attributes.address') }}
                        </div>

                        <base-tippy :content="family.address" class="truncate">{{ family.address }}</base-tippy>
                    </div>

                    <div class="mt-2 flex">
                        <div class="w-44 rtl:!font-semibold">
                            {{ $t('validation.attributes.zone') }}
                        </div>
                        {{ family.zone?.name }}
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
