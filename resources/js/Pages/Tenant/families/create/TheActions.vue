<script lang="ts" setup>
import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

interface Props {
    currentStep: number
    totalSteps: number
    validating: boolean
    prevStep: () => void
    nextStep: () => void
}

defineProps<Props>()
</script>

<template>
    <div class="intro-y col-span-12 mt-5 flex items-center justify-center sm:justify-end">
        <base-button
            v-if="currentStep > 1"
            :disabled="validating"
            class="w-24"
            data-test="previous"
            type="button"
            variant="secondary"
            @click="prevStep"
        >
            {{ $t('pagination.previous') }}
        </base-button>

        <base-button
            :disabled="validating"
            class="ms-2 w-24"
            data-test="next_or_register"
            type="submit"
            variant="primary"
            @click.prevent="nextStep"
        >
            <spinner-button-loader :show="validating"></spinner-button-loader>

            {{ currentStep === totalSteps ? $t('register') : $t('pagination.next') }}
        </base-button>
    </div>
</template>
