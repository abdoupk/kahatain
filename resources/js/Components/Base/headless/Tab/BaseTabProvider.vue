<script setup lang="ts">
import { type ComputedRef, computed, provide } from 'vue'

export type ProvideTab = {
    selected: ComputedRef<boolean>
}

interface ProviderProps {
    selected: boolean
}

const { selected = false } = defineProps<ProviderProps>()

provide<ProvideTab>('tab', {
    selected: computed(() => selected)
})
</script>

<template>
    <slot></slot>
</template>
