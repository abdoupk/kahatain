<script setup lang="ts">
import type { CreateFamilyForm } from '@/types/types'

import type { Form } from 'laravel-precognition-vue/dist/types'

import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseFormTextArea from '@/Components/Base/form/BaseFormTextArea.vue'

defineProps<{ form: Form<CreateFamilyForm> }>()

const otherProperties = defineModel('otherProperties')
</script>

<template>
    <div class="mt-6 grid grid-cols-12 gap-4 gap-y-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <base-form-label for="other_properties">
                {{ $t('validation.attributes.other_properties') }}
            </base-form-label>

            <!-- TODO change to Ckeditor -->
            <base-form-text-area
                v-model="otherProperties"
                id="other_properties"
                rows="8"
                :placeholder="$t('housing.placeholders.other_properties')"
                @change="
                    form?.validate(
                        // @ts-ignore
                        'other_properties'
                    )
                "
            ></base-form-text-area>

            <base-form-input-error>
                <div
                    data-test="error_other_properties_message"
                    class="mt-2 text-danger"
                    v-if="
                        form?.invalid(
                            // @ts-ignore
                            'other_properties'
                        )
                    "
                >
                    {{
                        // @ts-ignore
                        form.errors['other_properties']
                    }}
                </div>
            </base-form-input-error>
        </div>
    </div>
</template>
