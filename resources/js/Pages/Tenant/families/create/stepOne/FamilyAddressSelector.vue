<script lang="ts" setup>
import LeafletMap from '@/Pages/Tenant/dashboard/families-distribution/TheMap.vue'

import ShowModal from '@/Components/Global/ShowModal.vue'

defineProps<{
    open: boolean
    title: string
}>()

const emit = defineEmits(['close'])
</script>

<template>
    <show-modal :open :title size="xl" @close="emit('close')">
        <template #description>
            <div class="col-span-12 h-80 overflow-hidden rounded-md bg-slate-200">
                <leaflet-map class="h-full w-full"></leaflet-map>
            </div>
        </template>
    </show-modal>
</template>
