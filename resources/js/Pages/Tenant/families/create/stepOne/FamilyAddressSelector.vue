<script lang="ts" setup>
import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
    title: string
}>()

const emit = defineEmits(['close'])
</script>

<template>
    <show-modal :open :title size="lg" @close="emit('close')">
        <template #description> hello</template>
    </show-modal>
</template>
