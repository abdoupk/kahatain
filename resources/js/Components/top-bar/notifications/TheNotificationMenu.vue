<script lang="ts" setup>
import type { DatabaseNotification } from '@/types/types'

import { useNotificationsStore } from '@/stores/notifications'
import { router } from '@inertiajs/vue3'
import { useIntersectionObserver } from '@vueuse/core'
import { defineAsyncComponent, onMounted, ref } from 'vue'

import NotificationLoader from '@/Components/top-bar/notifications/NotificationLoader.vue'

import { downloadFile } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const NotificationAvatar = defineAsyncComponent(
    () => import('@/Components/top-bar/notifications/NotificationAvatar.vue')
)

const NotificationContent = defineAsyncComponent(
    () => import('@/Components/top-bar/notifications/NotificationContent.vue')
)

const props = defineProps<{
    close: () => void
}>()

const last = ref()

const loading = ref(false)

const notificationsStore = useNotificationsStore()

onMounted(async () => {
    loading.value = true

    await notificationsStore.getNotifications()

    loading.value = false
})

useIntersectionObserver(last, ([{ isIntersecting }]) => {
    if (!isIntersecting) {
        return
    }

    if (notificationsStore.notifications?.links.next) {
        loading.value = true

        notificationsStore.loadMoreNotifications().finally(() => {
            loading.value = false
        })
    }
})

const redirect = (url: string) => {
    if (url) {
        props.close()

        router.visit(url)
    }
}

const markAsRead = (notification: DatabaseNotification) => {
    notificationsStore.markAsRead(notification.id)

    if (notification.data.metadata?.subject === 'data_exported') {
        props.close()

        downloadFile(notification.data.metadata.url, '')
    } else {
        redirect(notification.data.metadata.url)
    }
}
</script>

<template>
    <div class="mb-5 font-medium">{{ $t('notifications') }}</div>

    <div v-if="notificationsStore.notifications?.data?.length">
        <div
            v-for="notification in notificationsStore.notifications?.data"
            :key="notification.id"
            :class="[
                'relative -mx-2 -my-2 mt-5 flex  cursor-pointer items-center rounded-lg px-2 py-1',
                { 'bg-slate-100 dark:bg-darkmode-400': !notification.read_at }
            ]"
            @click.prevent="markAsRead(notification)"
        >
            <notification-avatar
                :gender="notification.data.user?.gender"
                :name="notification.data.user?.name"
            ></notification-avatar>

            <notification-content :close :notification="notification"></notification-content>
        </div>
    </div>

    <div v-if="!loading && !notificationsStore.notifications?.data?.length" class="flex items-center justify-center">
        {{ $t('no_notifications') }}
    </div>

    <notification-loader v-if="loading"></notification-loader>

    <div ref="last" class="-translate-y-2"></div>
</template>
