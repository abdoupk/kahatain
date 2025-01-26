<script lang="ts" setup>
import type { BabiesMilkAndDiapersResource, IndexParams, PaginationData } from '@/types/types'

import { Link } from '@inertiajs/vue3'

import BaseTippy from '@/Components/Base/tippy/BaseTippy.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    orphans: PaginationData<BabiesMilkAndDiapersResource>
    params: IndexParams
}>()
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden">
        <div v-for="orphan in orphans.data" :key="orphan.id" class="intro-y !z-10 col-span-12 @xl:col-span-6">
            <div class="box p-5">
                <div class="flex">
                    <div class="me-3 truncate text-lg font-medium">
                        <Link :href="route('tenant.orphans.show', orphan.orphan.id)" class="font-medium">
                            {{ orphan.orphan.name }}
                        </Link>
                    </div>
                    <div
                        class="ms-auto flex cursor-pointer items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500 dark:bg-darkmode-400"
                    >
                        {{ orphan.orphan.age }}
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-12 gap-2">
                    <p class="col-span-12 text-base">
                        <Link
                            v-if="orphan.sponsor.id"
                            :href="route('tenant.sponsors.show', orphan.sponsor.id)"
                            class="font-medium rtl:font-semibold"
                        >
                            {{ orphan.sponsor?.name }}
                        </Link>
                    </p>

                    <div class="col-span-12 mt-2 grid grid-cols-12 gap-2">
                        <div class="col-span-12 grid grid-cols-12 gap-2">
                            <p class="col-span-4 rtl:font-semibold">{{ $t('baby_milk') }}</p>
                            <p class="col-span-8">
                                {{ orphan.orphan.baby_milk_type }} ({{ orphan.orphan.baby_milk_quantity }})
                            </p>
                        </div>

                        <div class="col-span-12 grid grid-cols-12 gap-2">
                            <p class="col-span-4 rtl:font-semibold">{{ $t('diapers') }}</p>
                            <p class="col-span-8">
                                {{ orphan.orphan.diapers_type }} ({{ orphan.orphan.diapers_quantity }})
                            </p>
                        </div>
                    </div>
                    <div
                        class="mt-2 flex h-fit w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-400/80 dark:bg-darkmode-400"
                    >
                        <base-tippy :content="$t('sponsor_phone_number')">
                            {{ orphan.sponsor?.phone_number }}
                        </base-tippy>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
