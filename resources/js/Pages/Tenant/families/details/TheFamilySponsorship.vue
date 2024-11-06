<script lang="ts" setup>
import type { FamilySponsorshipType } from '@/types/families'

import NoResultsFound from '@/Components/Global/NoResultsFound.vue'

import { handleSponsorship, isEmpty, omit } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ sponsorships: FamilySponsorshipType }>()
</script>

<template>
    <!-- BEGIN: Family SponsorShip -->
    <div v-if="!isEmpty(omit(sponsorships, ['id']))" class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('family_sponsorship') }}</h2>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <template v-for="(sponsorship, key) in omit(sponsorships, ['id'])" :key="key">
                <div v-if="sponsorship" class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">
                        {{ $t(`sponsorships.${key}`) }}
                    </h2>

                    <p class="text-base font-medium">
                        {{ handleSponsorship(sponsorship) }}
                    </p>
                </div>
            </template>
        </div>
    </div>

    <div v-else class="intro-x col-span-12 flex flex-col items-center justify-center @container 2xl:col-span-6">
        <no-results-found> {{ $t('family_sponsorship.not_found') }}</no-results-found>
    </div>
    <!-- END: Family SponsorShip -->
</template>
