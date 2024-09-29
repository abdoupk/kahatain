<script lang="ts">
type Variant = 'default' | 'boxed'
</script>

<script setup lang="ts">
import { type ComputedRef, computed, provide, ref, useSlots } from 'vue'

export type ProvideGroup = ComputedRef<{
    selectedIndex?: number
    setSelectedIndex: (value: number) => void
    variant?: Variant
}>

interface GroupProps {
    as?: string | object
    selectedIndex?: number
    variant?: Variant
}

const slots = useSlots()

const { as, selectedIndex, variant } = withDefaults(defineProps<GroupProps>(), {
    as: 'div',
    selectedIndex: 0,
    variant: 'default'
})

const active = ref(selectedIndex)

const setActive = (value: number) => {
    active.value = value
}

provide<ProvideGroup>(
    'group',
    computed(() => {
        return {
            selectedIndex: active.value,
            setSelectedIndex: setActive,
            variant: variant
        }
    })
)
</script>

<template>
    <component :is="as">
        <!--        TODO solve :index issue -->
        <component v-for="(item, key) in slots.default && slots.default()" :is="item" :key="key" />
    </component>
</template>
