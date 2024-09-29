<script lang="ts" setup>
import type { CityType, Daira } from '@/types/types'

import { useCityStore } from '@/stores/city'
import { onMounted, ref, watch } from 'vue'

import BaseFormLabel from '@/Components/Base/form/BaseFormLabel.vue'
import BaseVueSelect from '@/Components/Base/vue-select/BaseVueSelect.vue'

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

        cityStore.getDaira(props.city.daira_name)

        selectedDaira.value = cityStore.daira
    }
})

const handleChange = async () => {
    cityStore.getDaira(selectedDaira.value?.daira_name)

    selectedDaira.value = cityStore.daira

    await cityStore.fetchCommunes(cityStore.daira?.daira_name, cityStore.wilaya?.wilaya_code)

    daira.value = selectedDaira.value

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

        <div>
            <!-- @vue-ignore -->
            <base-vue-select
                id="dairas"
                v-model:value="selectedDaira"
                :options="cityStore.dairas"
                :placeholder="$t('auth.placeholders.tomselect', { attribute: $t('daira') })"
                class="h-full w-full"
                label="daira_name"
                track-by="id"
                @update:value="handleChange"
            >
            </base-vue-select>
        </div>
    </div>
</template>
