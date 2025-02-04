<script lang="ts" setup>
import type { OrphanShowType } from '@/types/orphans'

import { Head, Link } from '@inertiajs/vue3'

import TheLayout from '@/Layouts/TheLayout.vue'

import TheAvatar from '@/Components/Global/TheAvatar.vue'
import TheContentLoader from '@/Components/Global/theContentLoader.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { formatCurrency, formatDate, hasPermission, isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

defineOptions({
    layout: TheLayout
})

defineProps<{
    orphan: OrphanShowType
}>()
</script>

<template>
    <Head :title="$t('orphan details')"></Head>

    <suspense>
        <div>
            <div class="intro-y mt-8 flex items-center">
                <h2 class="me-auto text-lg font-medium ltr:capitalize">
                    {{ $t('orphan details') }}
                </h2>
            </div>

            <div class="mt-5 grid grid-cols-12 gap-6">
                <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
                    <div class="grid grid-cols-12 gap-6">
                        <!-- BEGIN: Orphan Information -->
                        <div class="intro-y box col-span-12 @container 2xl:col-span-9">
                            <div
                                class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3"
                            >
                                <!--                                <h2 class="me-auto text-xl font-bold">{{ orphan.name }}</h2>-->

                                <div class="image-fit h-12 w-12">
                                    <img v-if="orphan.photo" :src="orphan.photo" alt="" class="rounded-full" />
                                    <the-avatar v-else :gender="orphan.gender" :name></the-avatar>
                                </div>

                                <div class="me-auto ms-4">
                                    <div class="text-base font-bold">{{ orphan.name }}</div>

                                    <Link
                                        :href="route('tenant.members.index') + '?show=' + orphan.creator?.id"
                                        class="text-xs font-semibold text-slate-500"
                                    >
                                        {{ orphan.creator?.name }}
                                    </Link>
                                </div>

                                <Link
                                    v-if="hasPermission('edit_orphans')"
                                    :href="route('tenant.orphans.edit', orphan.id)"
                                >
                                    <svg-loader class="inline h-4 w-4" name="icon-pen"></svg-loader>

                                    {{ $t('edit') }}
                                </Link>
                            </div>

                            <div class="grid grid-cols-12 gap-4 p-5">
                                <div class="col-span-12 @xl:col-span-6">
                                    <h2 class="text-lg font-semibold">
                                        {{ $t('validation.attributes.date_of_birth') }}
                                    </h2>

                                    <h3 class="text-base font-medium">
                                        {{ formatDate(orphan.birth_date, 'long') }}
                                    </h3>
                                </div>

                                <div class="col-span-12 @xl:col-span-6">
                                    <h2 class="text-lg font-semibold">{{ $t('health_status') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ orphan.health_status }}

                                        <span v-if="orphan.is_handicapped"> ({{ $t('handicapped') }})</span>
                                    </h3>
                                </div>

                                <div v-if="orphan.family_status" class="col-span-12 @xl:col-span-6">
                                    <h2 class="text-lg font-semibold">{{ $t('family_status') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ $t(`family_statuses.${orphan.family_status}`) }}
                                    </h3>
                                </div>

                                <div v-if="orphan.academic_level" class="col-span-12 @xl:col-span-6">
                                    <h2 class="text-lg font-semibold">{{ $t('academic_level') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ orphan.academic_level || '————' }}
                                    </h3>
                                </div>

                                <div v-if="orphan.institution" class="col-span-12 @xl:col-span-6">
                                    <h2 class="text-lg font-semibold">{{ $t('validation.attributes.institution') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ orphan.institution || '————' }}
                                    </h3>
                                </div>

                                <div v-if="orphan.speciality" class="col-span-12 @xl:col-span-6">
                                    <h2 class="text-lg font-semibold">{{ $t('speciality') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ orphan.speciality || '————' }}
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
                                            {{ orphan.baby_needs.diapers_type }}
                                        </h3>
                                    </div>

                                    <div class="col-span-12 @xl:col-span-6">
                                        <h2 class="text-lg font-semibold">{{ $t('diapers_quantity') }}</h2>

                                        <h3 class="text-base font-medium">
                                            {{ orphan.baby_needs.diapers_quantity }}
                                        </h3>
                                    </div>

                                    <div class="col-span-12 @xl:col-span-6">
                                        <h2 class="text-lg font-semibold">{{ $t('baby_milk_type') }}</h2>

                                        <h3 class="text-base font-medium">
                                            {{ orphan.baby_needs.baby_milk_type }}
                                        </h3>
                                    </div>

                                    <div class="col-span-12 @xl:col-span-6">
                                        <h2 class="text-lg font-semibold">{{ $t('baby_milk_quantity') }}</h2>

                                        <h3 class="text-base font-medium">
                                            {{ orphan.baby_needs.baby_milk_quantity }}
                                        </h3>
                                    </div>
                                </template>

                                <div
                                    v-if="orphan.phone_number || isOlderThan(orphan.birth_date, 18)"
                                    class="col-span-12 sm:col-span-6"
                                >
                                    <h2 class="text-lg font-semibold">
                                        {{ $t('validation.attributes.phone_number') }}
                                    </h2>

                                    <h3 class="text-base font-medium">
                                        {{ orphan.phone_number || '————' }}
                                    </h3>
                                </div>

                                <div
                                    v-if="orphan.ccp || isOlderThan(orphan.birth_date, 18)"
                                    class="col-span-12 sm:col-span-6"
                                >
                                    <h2 class="text-lg font-semibold">{{ $t('ccp') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ orphan.ccp || '————' }}
                                    </h3>
                                </div>

                                <div v-if="isOlderThan(orphan.birth_date, 18)" class="col-span-12 sm:col-span-6">
                                    <h2 class="text-lg font-semibold">
                                        {{ $t('unemployed') }}
                                    </h2>

                                    <h3 class="text-base font-medium">
                                        {{ orphan.is_unemployed ? $t('yes') : $t('no') || '————' }}
                                    </h3>
                                </div>

                                <div
                                    v-if="orphan.income || isOlderThan(orphan.birth_date, 18)"
                                    class="col-span-12 sm:col-span-6"
                                >
                                    <h2 class="text-lg font-semibold">{{ $t('the_income') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ formatCurrency(orphan.income) }}
                                    </h3>
                                </div>

                                <div class="col-span-12 sm:col-span-6">
                                    <h2 class="text-lg font-semibold">{{ $t('income_rate') }}</h2>

                                    <h3 class="text-base font-medium">
                                        {{ formatCurrency(orphan.income_rate) }}
                                    </h3>
                                </div>

                                <div v-if="orphan.note" class="col-span-12">
                                    <h2 class="text-lg font-semibold">{{ $t('notes') }}</h2>

                                    <div class="text-base font-normal" v-html="orphan.note"></div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Orphan Information -->
                    </div>
                </div>
            </div>
        </div>

        <template #fallback>
            <the-content-loader></the-content-loader>
        </template>
    </suspense>
</template>
