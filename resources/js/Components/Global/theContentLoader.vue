<script lang="ts" setup>
import { onMounted, ref } from 'vue'

import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'

const ready = ref(false)

onMounted(() => {
    setTimeout(() => {
        ready.value = true
    }, 300)
})
</script>

<template>
    <Suspense v-if="ready">
        <div class="mt-16 flex h-screen w-full items-start justify-center">
            <spinner-loader class="h-8 w-8"></spinner-loader>
        </div>

        <template #fallback>
            <slot name="fallback"></slot>
        </template>
    </Suspense>
</template>
