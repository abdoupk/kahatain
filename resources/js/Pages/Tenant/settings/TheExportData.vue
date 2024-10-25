<script lang="ts" setup>
import { router } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SuccessNotification from '@/Components/Global/SuccessNotification.vue'

import { $t } from '@/utils/i18n'

const showSuccessNotification = ref(false)

const requestData = () => {
    router.post(
        route('tenant.site-settings.export-data'),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                showSuccessNotification.value = true

                nextTick(() => {
                    showSuccessNotification.value = false
                })
            }
        }
    )
}
</script>

<template>
    <div class="intro-y col-span-12 lg:col-span-5 2xl:col-span-6 box h-fit @container">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-5 dark:border-darkmode-400 sm:py-3">
            <h2 class="me-auto text-xl font-bold">{{ $t('export_data') }}</h2>
        </div>

        <div class="p-5 text-base/6">
            <p>{{ $t('export_data_description') }}</p>

            <base-button class="mt-5" variant="primary" @click.prevent="requestData">
                {{ $t('request_data') }}
            </base-button>
        </div>
    </div>

    <success-notification :open="showSuccessNotification" :title="$t('successfully_exported')"></success-notification>
</template>
