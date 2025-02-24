<script lang="ts" setup>
import BaseTab from '@/Components/Base/headless/Tab/BaseTab.vue'
import BaseTabButton from '@/Components/Base/headless/Tab/BaseTabButton.vue'

defineProps<{
    phases: string[]
}>()
</script>

<template>
    <base-tab v-for="phase in phases" :key="phase">
        <base-tab-button as="button" class="w-full px-2 py-1.5">
            {{ $t(`phase_${phase}`) }}
        </base-tab-button>
    </base-tab>
</template>
