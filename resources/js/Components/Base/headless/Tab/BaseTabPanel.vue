<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { TabPanel as HeadlessTabPanel, TransitionRoot } from '@headlessui/vue'

interface PanelProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessTabPanel> {}

defineProps<PanelProps>()
</script>

<template>
    <headless-tab-panel as="template" v-slot="{ selected }">
        <transition-root
            appear
            as="div"
            :show="selected"
            enter="transition-opacity duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="transition-opacity duration-300"
            leave-from="opacity-100"
            leave-to="opacity-0"
        >
            <slot :selected="selected"></slot>
        </transition-root>
    </headless-tab-panel>
</template>
