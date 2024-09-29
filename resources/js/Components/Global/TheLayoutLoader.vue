<script lang="ts" setup>
import SpinnerLoader from '@/Components/Global/SpinnerLoader.vue'
</script>

<template>
    <suspense>
        <div class="flex h-screen w-screen flex-col items-center justify-center overflow-hidden">
            <spinner-loader class="h-10 w-10"></spinner-loader>

            <!--            <h3 class="mt-6 text-lg font-medium rtl:font-semibold">{{ $t('loading...') }}</h3>-->
        </div>

        <template #fallback>
            <slot name="fallback"></slot>
        </template>
    </suspense>
</template>
