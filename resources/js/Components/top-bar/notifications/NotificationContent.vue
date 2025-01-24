<script lang="ts" setup>
import type { DatabaseNotification } from '@/types/types'

import { router } from '@inertiajs/vue3'

import { formatDate } from '@/utils/helper'
import { $t, $tc } from '@/utils/i18n'

const props = defineProps<{
    notification: DatabaseNotification
    close: () => void
}>()

const handleShowMember = (id: string) => {
    if (id) {
        props.close()

        router.visit(route('tenant.members.index') + '?show=' + id)
    }
}
</script>

<template>
    <div class="ms-2 w-full overflow-hidden">
        <div class="flex items-center">
            <a
                class="me-5 truncate font-medium rtl:font-semibold"
                href="javascript:void(0)"
                @click.stop="handleShowMember(notification.data.user.id)"
            >
                {{ notification.data.user.name === 'support_team' ? $t('support_team') : notification.data.user.name }}
            </a>

            <div v-if="notification.data.metadata?.created_at" class="ms-auto whitespace-nowrap text-xs text-slate-400">
                {{ formatDate(notification.data.metadata.created_at, 'medium') }}
            </div>
        </div>

        <div
            class="mt-0.5 line-clamp-2 w-full text-slate-500"
            v-html="
                $tc(`notifications.${notification.type}`, notification.data.user.gender === 'male' ? 1 : 0, {
                    ...notification.data.data
                })
            "
        ></div>
    </div>
</template>
