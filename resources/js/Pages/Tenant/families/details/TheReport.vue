<script lang="ts" setup>
import type { PreviewType } from '@/types/families'

import { Link } from '@inertiajs/vue3'

import { formatDate } from '@/utils/helper'

defineProps<{ preview: PreviewType }>()
</script>

<template>
    <!-- BEGIN: The Report -->
    <div class="intro-y box col-span-12 @container 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('the_report') }}</h2>

            <div
                class="mt-2 flex w-fit items-center truncate rounded-full bg-slate-100 px-2 py-1 text-sm font-medium text-slate-400 dark:bg-darkmode-400"
            >
                {{ formatDate(preview.preview_date, 'long') }}
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="prose col-span-12 dark:prose-invert prose-th:text-start" v-html="preview?.report"></div>

            <div class="col-span-12"></div>
        </div>
    </div>
    <!-- END: The Report -->

    <!-- BEGIN: Inspectors members -->
    <div class="intro-y box col-span-12 2xl:col-span-6">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">
                {{ $t('inspectors_members') }}
            </h2>
        </div>

        <div class="grid grid-cols-12 gap-4 p-5">
            <div class="col-span-12">
                <Link
                    v-for="member in preview.inspectors"
                    :key="member.id"
                    :href="route('tenant.members.index') + '?show=' + member.id"
                    class="mt-2 flex items-center rounded-md px-5 first:mt-0 last:mb-3"
                >
                    <div class="me-3 h-2 w-2 rounded-full bg-current"></div>

                    <span class="text-base font-semibold">{{ member.name }}</span>
                </Link>
            </div>
        </div>
    </div>
    <!-- END: Inspectors members -->
</template>
