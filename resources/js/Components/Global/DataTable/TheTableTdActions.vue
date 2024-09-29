<script lang="ts" setup>
import TheTableTd from '@/Components/Global/DataTable/TheTableTd.vue'
</script>

<template>
    <the-table-td
        class="relative w-56 py-0 before:absolute before:inset-y-0 before:start-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400"
    >
        <slot></slot>
    </the-table-td>
</template>
