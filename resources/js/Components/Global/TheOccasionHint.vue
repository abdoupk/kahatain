<script lang="ts" setup>
import BaseAlert from '@/Components/Base/Alert/BaseAlert.vue'
import TheAlertDismissButton from '@/Components/Base/Alert/TheAlertDismissButton.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

import { $t } from '@/utils/i18n'

defineProps<{
    hintType: string
    onHidden: () => void
}>()
</script>

<template>
    <div class="intro-x">
        <base-alert
            v-slot="{ dismiss }"
            :on-hidden="onHidden"
            class="mt-5 w-fit dark:border-darkmode-400 dark:bg-darkmode-400"
            dismissible
            variant="soft-danger"
        >
            <div class="flex items-center">
                <span>
                    <svg-loader class="me-3 h-6 w-6" name="icon-triangle-exclamation" />
                </span>

                <span class="text-slate-800 dark:text-slate-500">
                    {{ $t(`hints.${hintType}`) }}
                </span>

                <the-alert-dismiss-button @click="dismiss">
                    <svg-loader class="stroke-red-900 dark:!stroke-white" name="icon-x"></svg-loader>
                </the-alert-dismiss-button>
            </div>
        </base-alert>
    </div>
</template>
