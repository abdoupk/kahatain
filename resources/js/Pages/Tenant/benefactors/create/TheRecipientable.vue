<script lang="ts" setup>
import { defineAsyncComponent } from 'vue'

import { $t } from '@/utils/i18n'

const BaseInputError = defineAsyncComponent(() => import('@/Components/Base/form/BaseInputError.vue'))

const FamilySelector = defineAsyncComponent(() => import('@/Pages/Tenant/benefactors/create/TheFamilySelector.vue'))

const OrphanSelector = defineAsyncComponent(() => import('@/Pages/Tenant/needs/create/OrphanSelector.vue'))

const BaseFormLabel = defineAsyncComponent(() => import('@/Components/Base/form/BaseFormLabel.vue'))

const BaseListBox = defineAsyncComponent(() => import('@/Components/Base/headless/Listbox/BaseListBox.vue'))

const recipientType = defineModel('recipientType', { default: 'orphan' })

const recipient = defineModel('recipient', { default: '' })

defineProps<{ errorMessage?: string | string[] }>()

const recipientTypes = [
    {
        label: $t('the_orphan'),
        value: 'orphan'
    },
    {
        label: $t('the_family'),
        value: 'family'
    }
]
</script>

<template>
    <div class="grid w-full flex-1 grid-cols-1 gap-4 gap-y-5 lg:grid-cols-2">
        <div>
            <base-form-label for="recipient_type">
                {{ $t('recipient_type') }}
            </base-form-label>

            <base-list-box
                id="university_speciality"
                v-model="recipientType"
                :model-value="recipientType"
                :options="recipientTypes"
                :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('recipient_type') })"
                @update:model-value="recipient = ''"
            ></base-list-box>
        </div>

        <div>
            <base-form-label for="recipient">
                {{ $t('the_recipient') }}
            </base-form-label>

            <div>
                <orphan-selector v-if="recipientType === 'orphan'" v-model:orphan="recipient"></orphan-selector>

                <family-selector v-else v-model:family="recipient"></family-selector>
            </div>

            <base-input-error v-if="errorMessage">
                <div class="mt-2 text-danger">
                    {{ $t('validation.required', { attribute: $t('the_recipient') }) }}
                </div>
            </base-input-error>
        </div>
    </div>
</template>
