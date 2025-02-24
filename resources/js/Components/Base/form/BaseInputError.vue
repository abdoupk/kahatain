<script setup lang="ts">
defineProps<{
    message?: string
}>()
</script>

<template>
    <transition>
        <div v-if="message">
            <p class="text-sm text-red-600">
                {{ message }}
            </p>
        </div>

        <div v-else>
            <slot></slot>
        </div>
    </transition>
</template>

<style lang="css" scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
