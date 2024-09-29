<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

const BaseExpandedVCalendar = defineAsyncComponent(
    () => import('@/Components/Base/VCalendar/BaseExpandedVCalendar.vue')
)

defineProps<{
    attributes: object[]
}>()
</script>

<template>
    <base-expanded-v-calendar :attributes></base-expanded-v-calendar>
</template>
