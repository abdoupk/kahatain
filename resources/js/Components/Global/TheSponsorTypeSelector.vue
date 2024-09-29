<script lang="ts" setup>
import { onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

const sponsorTypes = [
    {
        label: $t('sponsor_types.widower'),
        value: 'widower'
    },
    {
        label: $t('sponsor_types.widow'),
        value: 'widow'
    },
    {
        label: $t('sponsor_types.widows_husband'),
        value: 'widows_husband'
    },
    {
        label: $t('sponsor_types.widowers_wife'),
        value: 'widowers_wife'
    },
    {
        label: $t('sponsor_types.mother_of_a_supported_childhood'),
        value: 'mother_of_a_supported_childhood'
    },
    {
        label: $t('sponsor_types.other'),
        value: 'other'
    }
]

const handleUpdate = (sponsorType: { label: string; value: string }) => {
    type.value = sponsorType.value
}

const type = defineModel<string>('type')

const selectedType = ref<string | { label: string; value: string }>('')

onMounted(() => {
    if (type.value) {
        selectedType.value = {
            value: type.value,
            label: $t(`sponsor_types.${type.value}`)
        }
    }
})
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedType"
        :options="sponsorTypes"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('filters.sponsor_type') })"
        label="label"
        track_by="value"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
