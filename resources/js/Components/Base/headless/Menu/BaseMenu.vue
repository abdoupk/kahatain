<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { Menu as HeadlessMenu } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface MenuProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessMenu> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as = 'div' } = defineProps<MenuProps>()

const attrs = useComputedAttrs()

const computedClass = computed(() => twMerge(['relative', typeof attrs.class === 'string' && attrs.class]))
</script>

<template>
    <headless-menu as="template" v-slot="{ close }">
        <component :is="as" :class="computedClass" v-bind="attrs.attrs">
            <slot :close="close"></slot>
        </component>
    </headless-menu>
</template>
