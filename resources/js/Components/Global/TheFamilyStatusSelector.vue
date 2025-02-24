<script lang="ts" setup>
import { onMounted, ref, watch } from 'vue'

import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { isOlderThan } from '@/utils/helper'
import { $t } from '@/utils/i18n'

const familyStatus = defineModel<string>('familyStatus')

const gender = defineModel<'male' | 'female'>('gender', {
    default: 'male'
})

const birthDate = defineModel('birthDate')

const familyStatuses = ref([])

onMounted(() => {
    familyStatuses.value = getFamilyStatuses()
})

const getFamilyStatuses = () => {
    if (!isOlderThan(birthDate.value, 18)) {
        if (gender.value === 'male') {
            return [
                {
                    label: $t('family_statuses.professional_male'),
                    value: 'professionals'
                },
                {
                    label: $t('settings.dismissed'),
                    value: 'dismissed'
                }
            ]
        }

        return [
            {
                label: $t('family_statuses.professional_girl'),
                value: 'professionals'
            },
            {
                label: $t('settings.dismissed'),
                value: 'dismissed'
            }
        ]
    }

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
}

watch(
    () => [birthDate.value, gender.value],
    () => {
        familyStatus.value = ''

        familyStatuses.value = getFamilyStatuses()
    }
)
</script>

<template>
    <base-list-box
        v-model="familyStatus"
        :model-value="familyStatus"
        :options="familyStatuses"
        :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('family_status') })"
    ></base-list-box>
</template>
