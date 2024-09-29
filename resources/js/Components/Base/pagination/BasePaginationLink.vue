<script setup lang="ts">
import { twMerge } from 'tailwind-merge'
import { type LiHTMLAttributes, computed } from 'vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface LinkProps extends /* @vue-ignore */ LiHTMLAttributes {
    as?: string | object
    active?: boolean
}

defineOptions({
    inheritAttrs: false
})

const { as = 'a', active = false } = defineProps<LinkProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'min-w-0 sm:min-w-[40px] shadow-none font-normal flex items-center justify-center border-transparent text-slate-800 sm:me-2 dark:text-slate-300 px-1 sm:px-3',
        active && '!box font-medium dark:bg-darkmode-400',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <li class="flex-1">
        <base-button :as="as" :class="computedClass" v-bind="attrs.attrs">
            <slot></slot>
        </base-button>
    </li>
</template>
