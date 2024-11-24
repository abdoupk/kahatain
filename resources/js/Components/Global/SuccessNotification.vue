<script lang="ts" setup>
import { provide, ref, watch } from 'vue'

import BaseNotification, { type NotificationElement } from '@/Components/Base/notification/BaseNotification.vue'
import SvgLoader from '@/Components/Global/SvgLoader.vue'

const successNotification = ref<NotificationElement>()

provide('bind[successNotification]', (el: NotificationElement) => {
    successNotification.value = el
})

const props = defineProps<{ open: boolean; title: string; message?: string }>()

watch(props, (value) => {
    if (value.open) {
        successNotification.value?.showToast()
    }
})
</script>

<template>
    <base-notification
        :options="{
            duration: 3000,
            gravity: 'top',
            position: 'right'
        }"
        class="flex"
        data-test="successNotification"
        refKey="successNotification"
    >
        <svg-loader class="h-4 w-4 fill-success" name="icon-check-circle"></svg-loader>

        <div class="mx-4">
            <div class="font-medium">
                {{ props.title }}
            </div>
            <div v-if="props.message" class="mt-1 text-slate-500">{{ props.message }}}</div>
        </div>
    </base-notification>
</template>
