<script lang="ts" setup>
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { financialTransactionSpecifications } from '@/utils/constants'
import { $t } from '@/utils/i18n'

const specification = defineModel<string>('specification', { default: '' })

const selectedSpecification = ref<{ label: string; value: string } | string>('')

const financialTransactionSpecificationsLabels = ({ label }: { label: string }) => {
    return $t(label)
}

onMounted(async () => {
    selectedSpecification.value = { label: specification.value, value: specification.value }
})
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedSpecification"
        :custom-label="financialTransactionSpecificationsLabels"
        :options="financialTransactionSpecifications"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('validation.attributes.the_status') })"
        label="label"
        track_by="value"
        @update:value="specification = $event"
    ></base-vue-select>
</template>
