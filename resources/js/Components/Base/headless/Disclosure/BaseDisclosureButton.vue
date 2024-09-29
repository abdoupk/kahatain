<script setup lang="ts">
import type { ProvideGroup } from './BaseDisclosureGroup.vue'
import type { ProvideDisclosure } from './BaseDisclosureProvider.vue'

import type { ExtractProps } from '@/types/utils'

import { DisclosureButton as HeadlessDisclosureButton } from '@headlessui/vue'
import { twMerge } from 'tailwind-merge'
import { computed, inject, watch } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

interface ButtonProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessDisclosureButton> {
    as?: string | object
}

defineOptions({
    inheritAttrs: false
})

const { as } = withDefaults(defineProps<ButtonProps>(), {
    as: 'button'
})

const disclosure = inject<ProvideDisclosure>('disclosure')

const group = inject<ProvideGroup>('group')

if (group) {
    watch(group, () => {
        group.value.selectedIndex !== disclosure?.value.index && disclosure?.value.close()
    })
}

const attrs = useComputedAttrs()

const computedClass = computed(() =>
    twMerge([
        'outline-none py-4 -my-4 font-medium w-full text-left dark:text-slate-400',
        disclosure?.value.open && 'text-primary dark:text-slate-300',
        typeof attrs.class === 'string' && attrs.class
    ])
)
</script>

<template>
    <headless-disclosure-button
        as="template"
        @click="
            () => {
                disclosure && group?.setSelectedIndex(disclosure.index)
            }
        "
    >
        <component :is="as" :class="computedClass" v-bind="attrs.attrs">
            <slot></slot>
        </component>
    </headless-disclosure-button>
</template>
