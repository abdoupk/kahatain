<script lang="ts" setup>
import type { SVGType } from '@/types/types'

import { twMerge } from 'tailwind-merge'
import { defineAsyncComponent, shallowRef, watch } from 'vue'

import { useComputedAttrs } from '@/utils/useComputedAttrs'

defineOptions({
    inject: false
})

const props = withDefaults(defineProps<{ name: SVGType }>(), {
    name: 'loader-oval'
})

const attrs = useComputedAttrs()

const svgComponent = shallowRef(defineAsyncComponent(() => import(`../../../svg/${props.name}.svg`)))

watch(
    () => props.name,
    async (newName) => {
        svgComponent.value = await import(`../../svg/${newName}.svg`)
    }
)
</script>

<template>
    <component
        :is="svgComponent"
        :class="twMerge(['h-5 w-5 stroke-1.5', typeof attrs.class === 'string' && attrs.class])"
    ></component>
</template>
