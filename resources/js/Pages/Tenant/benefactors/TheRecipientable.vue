<script lang="ts" setup>
import FamilySelector from '@/Pages/Tenant/benefactors/FamilySelector.vue'
import OrphanSelector from '@/Pages/Tenant/needs/create/OrphanSelector.vue'

import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

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

            <base-form-input-error>
                <div v-if="errorMessage" class="mt-2 text-red-600">
                    {{ $t('validation.required', { attribute: $t('the_recipient') }) }}
                </div>
            </base-form-input-error>
        </div>
    </div>
</template>
