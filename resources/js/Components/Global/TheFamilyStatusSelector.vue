<script lang="ts" setup>
import { computed, onMounted, ref } from 'vue'

import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

import { $t } from '@/utils/i18n'

const familyStatus = defineModel<string>('familyStatus')

const gender = defineModel<'male' | 'female'>('gender', {
    default: 'male'
})

const familyStatuses = computed(() => {
    if (gender.value === 'male') {
        return [
            {
                label: $t('family_statuses.college_boy'),
                value: 'college_boy'
            },
            {
                label: $t('family_statuses.professional_boy'),
                value: 'professional_boy'
            },
            {
                label: $t('family_statuses.unemployed'),
                value: 'unemployed'
            },
            {
                label: $t('family_statuses.worker_with_family'),
                value: 'worker_with_family'
            },
            {
                label: $t('family_statuses.worker_outside_family'),
                value: 'worker_outside_family'
            },
            {
                label: $t('family_statuses.married_with_family'),
                value: 'married_with_family'
            },
            {
                label: $t('family_statuses.married_outside_family'),
                value: 'married_outside_family'
            }
        ]
    }

    return [
        {
            label: $t('family_statuses.college_girl'),
            value: 'college_girl'
        },
        {
            label: $t('family_statuses.professional_girl'),
            value: 'professional_girl'
        },
        {
            label: $t('family_statuses.at_home_with_no_income'),
            value: 'at_home_with_no_income'
        },
        {
            label: $t('family_statuses.at_home_with_income'),
            value: 'at_home_with_income'
        },
        {
            label: $t('family_statuses.single_female_employee'),
            value: 'single_female_employee'
        },
        {
            label: $t('family_statuses.married'),
            value: 'married'
        },
        {
            label: $t('family_statuses.divorced_outside_family'),
            value: 'divorced_outside_family'
        },
        {
            label: $t('family_statuses.divorced_with_family'),
            value: 'divorced_with_family'
        }
    ]
})

const handleUpdate = (status: { label: string; value: string }) => {
    familyStatus.value = status?.value
}

const selectedStatus = ref<string | { label: string; value: string }>('')

onMounted(() => {
    if (familyStatus.value) {
        selectedStatus.value = {
            label: $t(`family_statuses.${familyStatus.value}`),
            value: familyStatus.value
        }
    }
})
</script>

<template>
    <!--  @vue-ignore  -->
    <base-vue-select
        v-model:value="selectedStatus"
        :options="familyStatuses"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('family_status') })"
        label="label"
        track_by="value"
        @update:value="handleUpdate"
    ></base-vue-select>
</template>
