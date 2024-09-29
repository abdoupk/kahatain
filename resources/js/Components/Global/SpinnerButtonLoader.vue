<script setup lang="ts">
import { TransitionRoot } from '@headlessui/vue'

import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'

defineProps<{ show: boolean }>()
</script>

<template>
    <!-- TODO: Fix This its too late to appear or disappear -->
    <transition-root appear :show enter="transition ease-out" enterFrom="scale-0" enterTo="scale-100">
        <spinner-loader class="me-1 h-4 w-4 animate-spin text-current"></spinner-loader>
    </transition-root>
</template>
