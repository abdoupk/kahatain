<template>
    <div class="flex justify-start">
        <div
            v-for="color in colors"
            :key="color"
            :class="[$attrs.disabled ? '!cursor-not-allowed' : 'cursor-pointer']"
            class="relative ms-2 flex justify-center gap-4 first:ms-0"
        >
            <button
                :class="[
                    { 'ring-2': selectedColor === color },
                    {
                        'cursor-pointer ring-primary ring-offset-1 transition-all hover:ring-2 dark:ring-darkmode-200':
                            !$attrs.disabled
                    },
                    {
                        'cursor-not-allowed': $attrs.disabled
                    }
                ]"
                :disabled="$attrs.disabled"
                :style="{ backgroundColor: color }"
                class="block h-8 w-8 rounded-full"
                type="button"
                @click="selectColor(color)"
            ></button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

interface Props {
    modelValue: string
}

const props = defineProps<Props>()

const emit = defineEmits(['update:modelValue'])

// eslint-disable-next-line array-element-newline
const colors = ['#FF69B4', '#33CC33', '#6666CC', '#CC0000', '#87ceeb', '#0099CC', '#9900CC', '#CCCCCC']

const selectedColor = ref(props.modelValue)

function selectColor(color: string) {
    selectedColor.value = color

    emit('update:modelValue', color)
}
</script>
