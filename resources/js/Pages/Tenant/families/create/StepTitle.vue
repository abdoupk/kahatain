<script lang="ts" setup>
import BaseButton from '@/Components/Base/button/BaseButton.vue'

interface Props {
    currentStep: number
    index: number
    title: string
}

defineProps<Props>()

const emit = defineEmits(['goTo'])

const handleClick = (index: number) => emit('goTo', index)
</script>

<template>
    <div class="intro-x !z-[49] mt-5 flex flex-1 items-center first:mt-0 lg:mt-0 lg:block lg:text-center">
        <!-- TODO: fix animation delay   -->
        <transition :duration="150" mode="out-in" type="transition">
            <base-button
                v-if="index <= currentStep"
                class="h-10 w-10 rounded-full"
                type="button"
                variant="primary"
                @click.prevent="handleClick(index)"
            >
                {{ index }}
            </base-button>

            <base-button
                v-else
                class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 dark:border-darkmode-400 dark:bg-darkmode-400"
                type="button"
                @click.prevent="handleClick(index)"
            >
                {{ index }}
            </base-button>
        </transition>
        <div
            :class="{ 'font-medium rtl:font-bold': currentStep === index }"
            class="ms-3 block text-base text-slate-600 transition-all duration-150 dark:text-slate-400 lg:hidden rtl:font-semibold"
        >
            {{ $t(title) }}
        </div>

        <div
            :style="{ width: currentStep - 1 >= index ? '100%' : '0%' }"
            class="absolute start-1/2 top-4 -z-10 hidden h-[3px] w-0 bg-primary transition-all duration-500 lg:block"
        ></div>
    </div>
</template>
