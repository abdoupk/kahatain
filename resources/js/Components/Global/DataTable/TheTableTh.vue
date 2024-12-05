<script lang="ts" setup>
import BaseThTable from '@/Components/Base/table/BaseThTable.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

const { sortable = false } = defineProps<{
    sortable?: boolean
    field?: string
    direction?: 'asc' | 'desc'
}>()
</script>

<template>
    <base-th-table class="whitespace-nowrap border-b-0 font-semibold">
        <div v-if="sortable" class="flex cursor-pointer">
            <span class="flex-grow">
                <slot></slot>
            </span>

            <svg-loader v-if="direction === 'asc'" class="fill-current" name="icon-sort-up"></svg-loader>

            <svg-loader v-else-if="direction === 'desc'" class="fill-current" name="icon-sort-down"></svg-loader>
        </div>

        <span v-else><slot></slot></span>
    </base-th-table>
</template>
