<script setup lang="ts">
import type { ExtractProps } from '@/types/utils'

import { TabPanels as HeadlessTabPanels } from '@headlessui/vue'

interface PanelsProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessTabPanels> {}

defineProps<PanelsProps>()
</script>

<template>
    <headless-tab-panels as="div">
        <slot></slot>
    </headless-tab-panels>
</template>
