<script lang="ts" setup>
import type { CityType, Daira } from '@/types/types'

import { useCityStore } from '@/stores/city'
import { onMounted, ref, watch } from 'vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseListBox from '@/Components/Base/headless/Listbox/BaseListBox.vue'

const props = defineProps<{
    city: CityType
}>()

const cityStore = useCityStore()

const selectedDaira = ref<Daira>()

const daira = defineModel<Daira>('daira')

const emit = defineEmits(['update:modelValue'])

onMounted(async () => {
    if (props.city) {
        await cityStore.fetchDairas(props.city.wilaya_code)

        cityStore.getDairaByName(props.city.daira_name)

        selectedDaira.value = cityStore.daira?.id
    }
})

const handleChange = async () => {
    cityStore.getDairaById(selectedDaira.value)

    await cityStore.fetchCommunes(cityStore.daira?.daira_name, cityStore.wilaya?.wilaya_code)

    emit('update:modelValue', selectedDaira.value)
}

watch(
    () => daira.value,
    (value) => {
        selectedDaira.value = value
    }
)
</script>

<template>
    <div>
        <base-form-label for="dairas">
            {{ $t('daira') }}
        </base-form-label>

        <base-list-box
            id="dairas"
            v-model="selectedDaira"
            :model-value="selectedDaira"
            :options="cityStore.dairas"
            :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('daira') })"
            label-key="daira_name"
            value-key="id"
            @update:model-value="handleChange"
        ></base-list-box>
    </div>
</template>
