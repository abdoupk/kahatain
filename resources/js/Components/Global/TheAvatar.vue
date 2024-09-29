<script lang="ts" setup>
defineProps<{
    gender?: 'male' | 'female' | null
    name: string
}>()
</script>

<template>
    <img
        v-if="gender === 'female'"
        :alt="name"
        class="rounded-full border border-slate-400/65 p-0.5 dark:border-darkmode-200"
        src="/images/female-avatar.png"
    />

    <img
        v-else
        :alt="name"
        class="rounded-full border border-slate-400/65 p-0.5 dark:border-darkmode-200"
        src="/images/male-avatar.svg"
    />
</template>
