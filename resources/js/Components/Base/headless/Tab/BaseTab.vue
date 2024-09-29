<script setup lang="ts">
import type { ProvideList } from './BaseTabList.vue'
import BaseTabProvider from './BaseTabProvider.vue'

import type { ExtractProps } from '@/types/utils'

import { Tab as HeadlessTab } from '@headlessui/vue'
import { inject } from 'vue'

interface TabProps extends /* @vue-ignore */ ExtractProps<typeof HeadlessTab> {
    fullWidth?: boolean
}

const { fullWidth = true } = defineProps<TabProps>()

const list = inject<ProvideList>('list')
</script>

<template>
    <headless-tab as="template" v-slot="{ selected }">
        <li
            :class="[
                'focus-visible:outline-none',
                { 'flex-1': fullWidth },
                { '-mb-px': list && list.variant == 'tabs' }
            ]"
        >
            <base-tab-provider :selected="selected">
                <slot :selected="selected"></slot>
            </base-tab-provider>
        </li>
    </headless-tab>
</template>
