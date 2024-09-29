<script setup lang="ts">
import type { ProvideGroup } from './BaseDisclosureGroup.vue'
import Provider from './BaseDisclosureProvider.vue'

import type { ExtractProps } from '@/types/utils'

import { Disclosure as HeadlessDisclosure } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed, inject } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface DisclosureProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDisclosure> {
    index?: number
}

defineOptions({
    inheritAttrs: false
})

const { index = 0 } = defineProps<DisclosureProps>()

const group = inject<ProvideGroup>('group')

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'py-4 first:-mt-4 last:-mb-4',
        '[&:not(:last-child)]:border-b [&:not(:last-child)]:border-slate-200/60 [&:not(:last-child)]:dark:border-darkmode-400',
        group?.value.variant == 'boxed' &&
            'p-4 first:mt-0 last:mb-0 border border-slate-200/60 mt-3 dark:border-darkmode-400',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <headless-disclosure
        as="div"
        :default-open="group?.selectedIndex === index"
        :class="computedClass"
        v-bind="attrs.attrs"
        v-slot="{ open, close }"
    >
        <Provider :open="open" :close="close" :index="index">
            <slot :open="open" :close="close"></slot>
        </Provider>
    </headless-disclosure>
</template>
