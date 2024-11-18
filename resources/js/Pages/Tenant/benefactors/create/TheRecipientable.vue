<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const FamilySelector = defineAsyncComponent(() => import('@/Pages/Tenant/benefactors/create/TheFamilySelector.vue'))

const OrphanSelector = defineAsyncComponent(() => import('@/Pages/Tenant/needs/create/OrphanSelector.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseVueSelect = defineAsyncComponent(() => import('@/Components/Base/vue-select/BaseVueSelect.vue'))

const recipientType = defineModel('recipientType', { default: 'family' })

const recipient = defineModel('recipient', { default: '' })

defineProps<{ errorMessage?: string | string[] }>()

const recipientTypes = [
    {
        label: 'the_orphan',
        value: 'orphan'
    },
    {
        label: 'the_family',
        value: 'family'
    }
]

const recipientTypesLabels = ({ label }: { label: string }) => {
    return $t(label)
}
</script>

<template>
    <div class="grid w-full flex-1 grid-cols-1 gap-4 gap-y-5 lg:grid-cols-2">
        <div>
            <base-form-label for="recipient_type">
                {{ $t('recipient_type') }}
            </base-form-label>

            <div>
                <!-- @vue-ignore -->
                <base-vue-select
                    id="recipient_type"
                    :custom-label="recipientTypesLabels"
                    :options="recipientTypes"
                    :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('recipient_type') })"
                    class="h-full w-full"
                    label="label"
                    track_by="value"
                    @update:value="
                        (type) => {
                            recipientType = type.value

                            recipient = ''
                        }
                    "
                >
                </base-vue-select>
            </div>
        </div>

        <div>
            <base-form-label for="recipient">{{ $t('the_recipient') }}</base-form-label>

            <div>
                <orphan-selector
                    v-if="recipientType === 'orphan'"
                    v-model:orphan="recipient"
                    @update:selected-orphan="(orphan) => (recipient = orphan)"
                ></orphan-selector>

                <family-selector
                    v-else
                    v-model:family="recipient"
                    @update:selected-family="(family) => (recipient = family)"
                ></family-selector>
            </div>

            <base-input-error v-if="errorMessage">
                <div class="mt-2 text-danger">
                    {{ $t('validation.required', { attribute: $t('the_recipient') }) }}
                </div>
            </base-input-error>
        </div>
    </div>
</template>
