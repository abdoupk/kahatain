<script lang="ts" setup>
import type { LessonShowType } from '@/types/lessons'

import TheLayout from '@/Layouts/TheLayout.vue'

defineOptions({
    layout: TheLayout
})

defineProps<{ lesson: LessonShowType }>()
</script>

<template>
    {{ lesson }}
</template>
