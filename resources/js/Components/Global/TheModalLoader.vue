<script lang="ts" setup>
import { onMounted, ref } from 'vue'

import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'

const ready = ref(false)

onMounted(() => {
    setTimeout(() => {
        ready.value = true
    }, 200)
})
</script>

<template>
    <Suspense v-if="ready">
        <div class="flex space-x-4 p-5">
            <div class="flex-1 space-y-6 py-1">
                <div class="h-2 w-24 animate-pulse rounded bg-slate-300 dark:bg-darkmode-100"></div>

                <div class="flex h-48 items-center justify-center">
                    <spinner-loader class="h-8 w-8"></spinner-loader>
                </div>
            </div>
        </div>

        <template #fallback>
            <slot name="fallback"></slot>
        </template>
    </Suspense>
</template>
