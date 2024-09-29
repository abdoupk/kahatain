<script lang="ts" setup>
import type { FurnishingType, HousingType } from '@/types/families'

import { formatCurrency, handleFurnishings, omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const props = defineProps<{
    housing: HousingType
    furnishings: FurnishingType
}>()

const HousingValue = () => {
    if (props.housing.name === 'tenant') return formatCurrency(props.housing.value)

    if (props.housing.name === 'inheritance') return props.housing.value + ' ' + $t('m2')

    return props.housing.value
}
</script>

<template>
    <!-- BEGIN: Housing Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('housing information') }}</h2>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('housing.label.type') }}</h2>

                <p class="text-base font-medium">
                    {{ $t(`housing.label.${housing.name}`) }}
                </p>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('housing.label.info') }}</h2>
                <p class="text-base font-medium">
                    {{ HousingValue() }}
                </p>
            </div>

            <div
                v-for="(value, key) in omit(housing, ['id', 'name', 'value'])"
                :key
                :class="
                    // @ts-ignore
                    key !== 'other_properties' ? '@xl:col-span-6' : ''
                "
                class="col-span-12"
            >
                <template v-if="value">
                    <h2 class="text-lg font-semibold">
                        {{ $t(`housing.label.${key}`) }}
                    </h2>

                    <p class="text-base font-medium">
                        {{ value }}
                    </p>
                </template>
            </div>
        </div>
    </div>
    <!-- END: Housing Information -->

    <!-- BEGIN: Furnishings Information -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">
                {{ $t('furnishings information') }}
            </h2>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div v-for="(value, key) in omit(furnishings, ['id'])" :key class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">
                    {{ $t(`furnishings.${key}`) }}
                </h2>

                <p class="text-base font-medium">
                    {{ handleFurnishings(value) }}
                </p>
            </div>
        </div>
    </div>
    <!-- END: Furnishings Information -->
</template>
