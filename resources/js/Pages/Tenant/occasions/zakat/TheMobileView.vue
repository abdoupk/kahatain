<script lang="ts" setup>
import type { IndexParams, PaginationData, ZakatFamiliesResource } from '@/types/types'

import { useZakatStore } from '@/stores/zakat'
import { Link } from '@inertiajs/vue3'

import { formatCurrency } from '@/utils/helper'

defineProps<{
    families: PaginationData<ZakatFamiliesResource>
    params: IndexParams
}>()

const emit = defineEmits(['sort'])

const zakatStore = useZakatStore()

const checkAll = ($event) => {
    // Get all family IDs from props.families
    const families = props.families.data.map((family) => family.id)

    if ($event.target.checked) {
        // If checked, add all families to selectedFamilies
        if (zakatStore.zakat.families.length) {
            // Avoid duplication by filtering out existing ones
            zakatStore.zakat.families = [...new Set([...zakatStore.zakat.families, ...families])]
        } else {
            zakatStore.zakat.families = families
        }
    } else {
        // If unchecked, remove the current families from selectedFamilies
        zakatStore.zakat.families = zakatStore.zakat.families.filter((id) => !families.includes(id))
    }
}
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="family in families.data" :key="family.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        <Link v-if="family.sponsor.id" :href="route('tenant.sponsors.show', family.sponsor.id)">
                            {{ family.sponsor.name }}
                        </Link>
                    </div>
                    <div
                        v-if="family.sponsor.phone_number"
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ family.sponsor.phone_number }}
                    </div>
                </div>
                <div class="mt-6 flex">
                    <div class="w-3/4">
                        <p class="truncate">{{ family.address }}</p>

                        <div class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                            <Link
                                :href="route('tenant.zones.index') + `?show=${family.zone?.id}`"
                                class="mt-0.5 block whitespace-nowrap text-xs text-slate-500"
                            >
                                {{ family.zone?.name }}
                            </Link>
                        </div>
                        <div
                            class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                        >
                            {{ formatCurrency(family.total_income) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
