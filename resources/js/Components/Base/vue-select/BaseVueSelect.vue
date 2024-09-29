<script lang="ts" setup>
import Multiselect from 'vue-multiselect'

defineProps<{ options: Record<string, string | unknown> }>()

const value = defineModel('value')
</script>

<template>
    <multiselect v-model="value" :options="options" :show-labels="false">
        <template #noResult>
            <span>{{ $t('No results found.') }}</span>
        </template>

        <template #maxElements>
            <span>{{ $t('Maximum number of elements reached.') }}</span>
        </template>

        <template #noOptions>
            <span>{{ $t('List is empty.') }}</span>
        </template>
    </multiselect>
</template>

<!-- TODO change vue-multiselect.ssr.css  -->
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style lang="postcss">
@import '/resources/css/vendors/vue-multiselect.css';
</style>
