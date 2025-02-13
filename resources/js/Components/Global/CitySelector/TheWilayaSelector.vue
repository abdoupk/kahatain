<script lang="ts" setup>
import type { CityType, Wilaya } from '@/types/types'

import { useCityStore } from '@/stores/city'
import { onMounted, ref } from 'vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

import { isEmpty } from '@/utils/helper'

const props = defineProps<{
    city: CityType
}>()

const cityStore = useCityStore()

const selectedWilaya = ref<Wilaya>()

const emit = defineEmits(['update:modelValue'])

onMounted(async () => {
    await cityStore.fetchWilayas()

    if (!isEmpty(props.city)) selectedWilaya.value = props.city?.wilaya_code
})

const handleChange = async () => {
    cityStore.communes = []

    await cityStore.fetchDairas(selectedWilaya.value)

    cityStore.getWilaya(selectedWilaya.value)

    emit('update:modelValue')
}
</script>

<template>
    <div>
        <base-form-label for="wilayas">
            {{ $t('wilaya') }}
        </base-form-label>

        <base-list-box
            id="wilayas"
            v-model="selectedWilaya"
            :model-value="selectedWilaya"
            :options="cityStore.wilayas"
            :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('wilaya') })"
            label-key="wilaya_name"
            value-key="wilaya_code"
            @update:model-value="handleChange"
        ></base-list-box>
    </div>
</template>
