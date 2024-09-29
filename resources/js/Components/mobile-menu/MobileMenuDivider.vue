<script lang="ts" setup>
import { twMerge } from 'tailwind-merge'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

const attrs = useComputedAttrs()
</script>

<template>
    <div :class="twMerge(['menu__divider', typeof attrs.class === 'string' && attrs.class])" v-bind="attrs.attrs"></div>
</template>
