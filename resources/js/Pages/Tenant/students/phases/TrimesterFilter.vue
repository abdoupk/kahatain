<script lang="ts" setup>
import BaseFormCheck from '@/Components/Base/form/form-check/BaseFormCheck.vue'
import BaseFormCheckInput from '@/Components/Base/form/form-check/BaseFormCheckInput.vue'
import BaseFormCheckLabel from '@/Components/Base/form/form-check/BaseFormCheckLabel.vue'

const emit = defineEmits(['filter'])
</script>

<template>
    <div class="mt-0 flex flex-row justify-items-center">
        <base-form-check class="m-2">
            <base-form-check-input
                id="first-trimester"
                name="trimester_filter"
                type="radio"
                value="first_trimester"
                @update:model-value="emit('filter', $event)"
            ></base-form-check-input>

            <base-form-check-label htmlFor="first-trimester">
                {{ $t('first_trimester') }}
            </base-form-check-label>
        </base-form-check>

        <base-form-check class="me-2">
            <base-form-check-input
                id="second-trimester"
                name="trimester_filter"
                type="radio"
                value="second_trimester"
                @update:model-value="emit('filter', $event)"
            ></base-form-check-input>

            <base-form-check-label htmlFor="second-trimester">
                {{ $t('second_trimester') }}
            </base-form-check-label>
        </base-form-check>

        <base-form-check>
            <base-form-check-input
                id="third-trimester"
                name="trimester_filter"
                type="radio"
                value="third_trimester"
                @update:model-value="emit('filter', $event)"
            ></base-form-check-input>

            <base-form-check-label htmlFor="third-trimester">
                {{ $t('third_trimester') }}
            </base-form-check-label>
        </base-form-check>
    </div>
</template>
