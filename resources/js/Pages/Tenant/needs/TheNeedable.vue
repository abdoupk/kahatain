<script lang="ts" setup>
import OrphanSelector from '@/Pages/Tenant/needs/create/OrphanSelector.vue'
import SponsorSelector from '@/Pages/Tenant/needs/create/SponsorSelector.vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseInputError from '@/Components/Base/form/BaseInputError.vue'
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { $t } from '@/utils/i18n'

const needableType = defineModel('needableType', { default: '' })

const needable = defineModel('needable', { default: '' })

defineProps<{ errorMessage?: string | string[] }>()
</script>

<template>
    <div class="grid w-full flex-1 grid-cols-1 gap-4 gap-y-5 lg:grid-cols-2">
        <div>
            <base-form-label for="needable_type">
                {{ $t('needable_type') }}
            </base-form-label>

            <base-list-box
                v-model="needableType"
                :options="[
                    { value: 'orphan', label: $t('the_orphan') },
                    { value: 'sponsor', label: $t('the_sponsor') }
                ]"
                :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('needable_type') })"
                @update:model-value="needable = ''"
            />
        </div>

        <div>
            <base-form-label for="needable">{{ $t('the_requester') }}</base-form-label>

            <div>
                <orphan-selector v-if="needableType === 'orphan'" v-model:orphan="needable"></orphan-selector>

                <sponsor-selector v-else v-model:sponsor="needable"></sponsor-selector>
            </div>

            <base-input-error v-if="errorMessage">
                <div class="mt-2 text-danger">
                    {{ $t('validation.required', { attribute: $t('the_requester') }) }}
                </div>
            </base-input-error>
        </div>
    </div>
</template>
