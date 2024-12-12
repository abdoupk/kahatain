<script lang="ts" setup>
defineProps<{
    orphans: unknown
    params: unknown
}>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['sort', 'showEditModal', 'showDetailsModal'])
</script>

<template>
    <div class="col-span-12 my-8 grid grid-cols-12 gap-4 @3xl:hidden"></div>
</template>
