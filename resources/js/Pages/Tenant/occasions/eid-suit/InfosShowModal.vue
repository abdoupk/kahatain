<script lang="ts" setup>
import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
}>()

const emit = defineEmits(['close'])
</script>

<template>
    <show-modal :open :title="$t('show')" size="xl" @close="emit('close')">
        <template #description></template>
    </show-modal>
</template>
