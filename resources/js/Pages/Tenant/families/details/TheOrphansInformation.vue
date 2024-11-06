<script lang="ts" setup>
import type { OrphanType } from '@/types/families'

import { formatDate, isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineProps<{ orphans: OrphanType[] }>()
</script>

<template>
    <!-- BEGIN: Orphans Information -->
    <div v-for="orphan in orphans" :key="orphan.id" class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ orphan.name }}</h2>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.date_of_birth') }}</h2>

                <h3 class="text-base font-medium">
                    {{ formatDate(orphan.birth_date, 'long') }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('health_status') }}</h2>

                <h3 class="text-base font-medium">
                    {{ orphan.health_status || '————' }}
                </h3>
            </div>

            <div v-if="orphan.family_status" class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('family_status') }}</h2>

                <h3 class="text-base font-medium">
                    {{ orphan.family_status ? $t(`family_statuses.${orphan.family_status}`) : '————' }}
                </h3>
            </div>

            <div v-if="orphan.family_status" class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('academic_level') }}</h2>

                <h3 class="text-base font-medium">
                    {{ orphan.academic_level || '————' }}
                </h3>
            </div>

            <div class="col-span-12 @xl:col-span-6">
                <h2 class="text-lg font-semibold">{{ $t('validation.attributes.sex') }}</h2>

                <h3 class="text-base font-medium">
                    {{ $t(orphan.gender) }}
                </h3>
            </div>

            <template v-if="isOlderThan(orphan.birth_date, 2)">
                <div class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">{{ $t('pants_size') }}</h2>

                    <h3 class="text-base font-medium">
                        {{ orphan.pants_size || '————' }}
                    </h3>
                </div>

                <div class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">{{ $t('shirt_size') }}</h2>

                    <h3 class="text-base font-medium">
                        {{ orphan.shirt_size || '————' }}
                    </h3>
                </div>

                <div class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">{{ $t('shoes_size') }}</h2>

                    <h3 class="text-base font-medium">
                        {{ orphan.shoes_size || '————' }}
                    </h3>
                </div>
            </template>

            <template v-else>
                <div class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">{{ $t('diapers_type') }}</h2>

                    <h3 class="text-base font-medium">
                        {{ orphan.baby_needs?.diapers_type || '————' }}
                    </h3>
                </div>

                <div class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">{{ $t('diapers_quantity') }}</h2>

                    <h3 class="text-base font-medium">
                        {{ orphan.baby_needs?.diapers_quantity || '————' }}
                    </h3>
                </div>

                <div class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">{{ $t('baby_milk_type') }}</h2>

                    <h3 class="text-base font-medium">
                        {{ orphan.baby_needs?.baby_milk_type || '————' }}
                    </h3>
                </div>

                <div class="col-span-12 @xl:col-span-6">
                    <h2 class="text-lg font-semibold">{{ $t('baby_milk_quantity') }}</h2>

                    <h3 class="text-base font-medium">
                        {{ orphan.baby_needs?.baby_milk_quantity || '————' }}
                    </h3>
                </div>
            </template>

            <!--            &lt;!&ndash; TODO: handle when the orphan still baby&ndash;&gt;-->

            <!--            <div class="col-span-12 @xl:col-span-6">-->
            <!--                <h2 class="text-lg font-semibold">{{ $t('pants_size') }}</h2>-->

            <!--                <h3 class="text-base font-medium">-->
            <!--                    {{ orphan.pants_size }}-->
            <!--                </h3>-->
            <!--            </div>-->

            <!--            <div class="col-span-12 @xl:col-span-6">-->
            <!--                <h2 class="text-lg font-semibold">{{ $t('shirt_size') }}</h2>-->

            <!--                <h3 class="text-base font-medium">-->
            <!--                    {{ orphan.shirt_size }}-->
            <!--                </h3>-->
            <!--            </div>-->

            <!--            <div class="col-span-12 @xl:col-span-6">-->
            <!--                <h2 class="text-lg font-semibold">{{ $t('shoes_size') }}</h2>-->

            <!--                <h3 class="text-base font-medium">-->
            <!--                    {{ orphan.shoes_size }}-->
            <!--                </h3>-->
            <!--            </div>-->

            <div v-if="orphan.note" class="col-span-12">
                <h2 class="text-lg font-semibold">{{ $t('notes') }}</h2>

                <div class="text-base font-normal" v-html="orphan.note"></div>
            </div>
        </div>
    </div>
    <!-- END: Orphans Information -->
</template>
