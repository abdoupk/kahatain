<script lang="ts" setup>
import { twMerge } from 'tailwind-merge'

import { $t } from '@/utils/i18n'
import { useComputedAttrs } from '@/utils/useComputedAttrs'

defineOptions({
    inheritAttrs: false
})

const attrs = useComputedAttrs()
</script>

<template>
    <p
        :class="
            twMerge([
                'p-4 text-center text-sm text-gray-500 dark:text-slate-400',
                typeof attrs.class === 'string' && attrs.class
            ])
        "
        v-bind="attrs.attrs"
    >
        {{ $t('No results found.') }}
    </p>
</template>
