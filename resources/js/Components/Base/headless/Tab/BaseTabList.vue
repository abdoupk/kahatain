<script lang="ts" setup>
import type { ExtractProps } from '@/types/utils'

import { TabList as HeadlessTabList } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed, provide } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

type Variant = 'tabs' | 'pills' | 'boxed-tabs' | 'link-tabs'

export type ProvideList = {
    variant?: Variant
}

interface ListProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessTabList> {
    variant?: Variant
}

defineOptions({
    inheritAttrs: false
})

const { variant = 'tabs' } = defineProps<ListProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        variant == 'tabs' && 'border-b border-slate-200 dark:border-darkmode-400',
        'w-full',
        typeof attrs.class === 'string' && attrs.class
    ])
)

provide<ProvideList>('list', {
    variant: variant
})
</script>

<template>
    <headless-tab-list :class="computedClass" as="ul" v-bind="$attrs">
        <slot></slot>
    </headless-tab-list>
</template>
