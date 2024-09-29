<script lang="ts" setup>
import TheAvatar from '@/Components/Global/TheAvatar.vue'

defineProps<{
    gender: 'male' | 'female' | null
    name: string
}>()
</script>

<template>
    <div class="relative me-1 h-12 w-12 flex-none">
        <the-avatar :gender :name class="rounded-full"></the-avatar>
    </div>
</template>
