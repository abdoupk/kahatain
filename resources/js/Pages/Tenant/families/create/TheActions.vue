<script lang="ts" setup>
import { useCreateFamilyStore } from '@/stores/create-family'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SpinnerButtonLoader from '@/Components/Global/SpinnerButtonLoader.vue'

interface Props {
    prevStep: () => void
    nextStep: () => void
}

defineProps<Props>()

const createFamilyStore = useCreateFamilyStore()
</script>

<template>
    <div class="intro-y col-span-12 mt-5 flex items-center justify-center sm:justify-end">
        <base-button
            v-if="createFamilyStore.current_step > 1"
            :disabled="false"
            class="w-24"
            data-test="previous"
            type="button"
            variant="secondary"
            @click="prevStep"
        >
            {{ $t('pagination.previous') }}
        </base-button>

        <base-button
            :disabled="false"
            class="ms-2 w-24"
            data-test="next_or_register"
            type="submit"
            variant="primary"
            @click.prevent="nextStep"
        >
            <spinner-button-loader :show="createFamilyStore.validating"></spinner-button-loader>

            {{
                createFamilyStore.current_step === createFamilyStore.total_steps
                    ? $t('register')
                    : $t('pagination.next')
            }}
        </base-button>
    </div>
</template>
