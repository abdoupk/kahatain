<script lang="ts" setup>
import { Form } from 'laravel-precognition-vue/dist/types'

defineProps<{
    field_name: string
    form: Form<unknown>
}>()
</script>
<template>
    <transition>
        <div
            v-bind="$attrs"
            v-if="form?.invalid(field_name)"
            class="mt-2 text-danger"
            :data-test="`error_${field_name}_message`"
        >
            {{ form.errors[field_name] }}
        </div>
    </transition>
</template>

<style lang="css" scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
