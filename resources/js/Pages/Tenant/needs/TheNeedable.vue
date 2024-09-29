<script lang="ts" setup>
import OrphanSelector from '@/Pages/Tenant/needs/create/OrphanSelector.vue'
import SponsorSelector from '@/Pages/Tenant/needs/create/SponsorSelector.vue'

import BaseFormInputError from '@/Components/Base/form/BaseFormInputError.vue'
import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

const needableType = defineModel('needableType', { default: 'orphan' })

const needable = defineModel('needable', { default: '' })

defineProps<{ errorMessage?: string | string[] }>()

const needableTypes = [
    {
        label: 'the_orphan',
        value: 'orphan'
    },
    {
        label: 'the_sponsor',
        value: 'sponsor'
    }
]

const needableTypesLabels = ({ label }: { label: string }) => {
    return $t(label)
}
</script>

<template>
    <div class="grid w-full flex-1 grid-cols-1 gap-4 gap-y-5 lg:grid-cols-2">
        <div>
            <base-form-label for="needable_type">
                {{ $t('needable_type') }}
            </base-form-label>

            <div>
                <!-- @vue-ignore -->
                <base-vue-select
                    id="needable_type"
                    :custom-label="needableTypesLabels"
                    :options="needableTypes"
                    :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('needable_type') })"
                    class="h-full w-full"
                    label="label"
                    track_by="value"
                    @update:value="
                        (type) => {
                            needableType = type.value

                            needable = ''
                        }
                    "
                >
                </base-vue-select>
            </div>
        </div>

        <div>
            <base-form-label for="needable">{{ $t('the_requester') }}</base-form-label>

            <div>
                <orphan-selector
                    v-if="needableType === 'orphan'"
                    v-model:orphan="needable"
                    @update:selected-orphan="(orphan) => (needable = orphan)"
                ></orphan-selector>

                <sponsor-selector
                    v-else
                    v-model:sponsor="needable"
                    @update:selected-sponsor="(sponsor) => (needable = sponsor)"
                ></sponsor-selector>
            </div>

            <base-form-input-error>
                <div v-if="errorMessage" class="mt-2 text-red-600">
                    {{ $t('validation.required', { attribute: $t('the_requester') }) }}
                </div>
            </base-form-input-error>
        </div>
    </div>
</template>
