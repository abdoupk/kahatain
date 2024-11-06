<script lang="ts" setup>
import type { RealTimeNotification } from '@/types/types'

import { useSettingsStore } from '@/stores/settings'
import { usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { twMerge } from 'tailwind-merge'
import { defineAsyncComponent, ref } from 'vue'
import { Toaster, toast } from 'vue-sonner'

import NotificationLoader from '@/Components/top-bar/notifications/NotificationLoader.vue'

import { debounce } from '@/utils/helper'
import { $t, $tc, getLocale } from '@/utils/i18n'
import { useComputedAttrs } from '@/utils/useComputedAttrs'

const BasePopover = defineAsyncComponent(() => import('@/Components/Base/headless/Popover/BasePopover.vue'))

const BasePopoverButton = defineAsyncComponent(() => import('@/Components/Base/headless/Popover/BasePopoverButton.vue'))

const BasePopoverPanel = defineAsyncComponent(() => import('@/Components/Base/headless/Popover/BasePopoverPanel.vue'))

const SvgLoader = defineAsyncComponent(() => import('@/Components/SvgLoader.vue'))

const TheNotificationMenu = defineAsyncComponent(
    () => import('@/Components/top-bar/notifications/TheNotificationMenu.vue')
)

const attrs = useComputedAttrs()

defineOptions({
    inheritAttrs: false
})

const settingsStore = useSettingsStore()

const { width } = useWindowSize()

const queue = ref<RealTimeNotification[]>([])

const stopShowNotification = ref(false)

const displayNextNotification = debounce(() => {
    if (queue.value.length === 0) return

    for (const notification of queue.value) {
        let notifier = notification.user.name

        if (notifier === 'support_team') {
            notifier = $t('support_team')
        }

        setTimeout(() => {
            toast(notifier, {
                onDismiss: () => (stopShowNotification.value = true),
                description: $tc(`notifications.${notification.type}`, notification.user.gender === 'male' ? 1 : 0, {
                    ...notification.data
                })
            })
        }, 1000)

        queue.value.shift()
    }
}, 1000)

window.Echo?.private('App.Models.User.' + usePage().props.auth.user.id).notification(
    (notification: RealTimeNotification) => {
        if (!stopShowNotification.value) {
            queue.value.push(notification)

            displayNextNotification()
        }
    }
)
</script>

<template>
    <base-popover class="intro-x me-auto sm:me-6">
        <base-popover-button
            :class="
                twMerge(
                    'relative block text-slate-600 outline-none before:absolute before:end-0.5 before:top-[-2px] before:h-[8px] before:w-[8px] before:rounded-full before:bg-danger before:content-[\'\']',
                    typeof attrs.class === 'string' && attrs.class
                )
            "
            v-bind="attrs.attrs"
        >
            <svg-loader
                :class="{
                    '!fill-slate-400': settingsStore.theme === 'enigma' || settingsStore.theme === 'rubick'
                }"
                class="dark:fill-slate-500"
                name="icon-bell"
            ></svg-loader>
        </base-popover-button>

        <base-popover-panel
            v-slot="{ close }"
            :placement="width < 640 ? 'bottom-start' : 'bottom-end'"
            class="scrollbar-hidden mt-2 max-h-[250px] w-[300px] overflow-y-auto scroll-smooth p-5 md:w-[380px]"
        >
            <suspense>
                <the-notification-menu :close="close"></the-notification-menu>

                <template #fallback>
                    <div>
                        <div class="mb-5 font-medium">{{ $t('notifications') }}</div>

                        <notification-loader></notification-loader>
                    </div>
                </template>
            </suspense>
        </base-popover-panel>
    </base-popover>

    <Toaster
        :dir="getLocale() === 'ar' ? 'rtl' : 'ltr'"
        :expand="false"
        :toast-options="{
            duration: 3000,
            unstyled: true,
            classes: {
                toast: 'rounded-lg border border-slate-200/60 bg-white py-5 px-6 shadow-xl dark:border-darkmode-600 dark:bg-darkmode-600 dark:text-slate-300',
                title: 'rtl:font-medium text-slate-800 dark:text-slate-300',
                description: 'text-red-400'
            }
        }"
        close-button
    />
</template>
