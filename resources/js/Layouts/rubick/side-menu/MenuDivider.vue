<script lang="ts" setup>
import { twMerge } from 'tailwind-merge'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

const attrs = useComputedAttrs()
</script>

<template>
    <div
        :class="
            twMerge(
                'relative z-10 h-px w-full bg-white/[0.08] dark:bg-white/[0.07]',
                typeof attrs.class === 'string' && attrs.class
            )
        "
        v-bind="attrs.attrs"
    ></div>
</template>
