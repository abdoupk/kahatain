<script lang="ts" setup>
import type { ExtractProps } from '@/types/utils'

import { MenuItem as HeadlessMenuItem } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface ItemProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessMenuItem> {
    method?: 'get' | 'post' | 'put' | 'patch' | 'delete'
    href?: string
    as?: string | Record<string, unknown>
    Vslot?: unknown
}

defineOptions({
    inheritAttrs: false
})

const { as = 'a', href = '#' } = defineProps<ItemProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'cursor-pointer flex items-center p-2 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dark:bg-darkmode-600 w-full dark:hover:bg-darkmode-400',
        attrs.attrs?.disabled && 'pointer-events-none opacity-50',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <headless-menu-item as="template" v-bind="$attrs">
        <component :is="as" :class="computedClass" :href as="button" v-bind="$attrs">
            <slot></slot>
        </component>
    </headless-menu-item>
</template>
