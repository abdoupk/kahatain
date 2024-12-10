<script lang="ts" setup>
const props = defineProps<{
    academicLevels: unknown
    totalTrainees: unknown
    traineesPerPhase: unknown
    studentsPerVocationalTrainingCenter: unknown
}>()

console.log(
    props.academicLevels,
    props.totalTrainees,
    props.traineesPerPhase,
    props.studentsPerVocationalTrainingCenter
)
</script>

<template></template>
