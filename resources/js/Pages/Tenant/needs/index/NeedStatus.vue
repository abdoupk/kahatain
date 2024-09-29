<script lang="ts" setup>
import type { NeedStatusType } from '@/types/types'

import { twMerge } from 'tailwind-merge'

defineProps<{ status: NeedStatusType }>()
</script>

<template>
    <span
        :class="
            twMerge([
                status === 'pending' && 'bg-pending/30 text-pending/90 dark:bg-pending/10',
                status === 'in_progress' && 'bg-secondary dark:bg-secondary/10',
                status === 'completed' && 'bg-success/30 text-success/90 dark:bg-success/10',
                status === 'rejected' && 'bg-danger/30 text-danger/90 dark:bg-danger/10'
            ])
        "
        class="whitespace-nowrap rounded-full px-2 py-1 font-medium"
        >{{ $t(status) }}</span
    >
</template>
