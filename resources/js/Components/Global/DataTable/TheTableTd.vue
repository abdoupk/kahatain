<script lang="ts" setup>
import BaseTdTable from '@/Components/Base/table/BaseTdTable.vue'
</script>

<template>
    <base-td-table
        class="border-b-0 bg-white first:rounded-s-md last:rounded-e-md dark:bg-darkmode-600 ltr:shadow-[20px_3px_20px_#0000000b] rtl:shadow-[-20px_3px_20px_#0000000b]"
    >
        <slot></slot>
    </base-td-table>
</template>
